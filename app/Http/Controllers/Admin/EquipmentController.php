<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
use App\Models\EquipmentDamagePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('category')->paginate(10);
        return view('admin.equipments.index', compact('equipments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:equipments',
            'qty_total' => 'required|integer|min:1',
            'condition' => 'required|in:baik,rusak ringan,rusak berat',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('equipments', $photoName, 'public');
        }

        Equipment::create([
            ...$validated,
            'qty_available' => $validated['qty_total'],
            'photo' => $photoName,
        ]);

        $this->logActivity(Auth::user(), "Membuat alat baru: {$validated['name']}");

        return redirect()->route('admin.equipments.index')->with('success', 'Alat berhasil dibuat');
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::all();
        $equipment->load('damagePrices');
        return view('admin.equipments.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:equipments,code,' . $equipment->id,
            'qty_total' => 'required|integer|min:1',
            'condition' => 'required|in:baik,rusak ringan,rusak berat',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'damage_prices.ringan' => 'nullable|numeric|min:0',
            'damage_prices.sedang' => 'nullable|numeric|min:0',
            'damage_prices.berat' => 'nullable|numeric|min:0',
        ]);

        // Handle photo upload
        $photoName = $equipment->photo;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($equipment->photo && Storage::disk('public')->exists('equipments/' . $equipment->photo)) {
                Storage::disk('public')->delete('equipments/' . $equipment->photo);
            }
            
            $photo = $request->file('photo');
            $photoName = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('equipments', $photoName, 'public');
        }

        // Update equipment basic fields
        $equipment->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'code' => $validated['code'],
            'qty_total' => $validated['qty_total'],
            'condition' => $validated['condition'],
            'description' => $validated['description'],
            'photo' => $photoName,
        ]);

        // Update damage prices if provided
        if (isset($validated['damage_prices'])) {
            foreach ($validated['damage_prices'] as $damageType => $price) {
                if ($price !== null && $price !== '') {
                    EquipmentDamagePrice::updateOrCreate(
                        [
                            'equipment_id' => $equipment->id,
                            'damage_type' => $damageType,
                        ],
                        [
                            'price' => $price,
                        ]
                    );
                }
            }
        }

        $this->logActivity(Auth::user(), "Mengubah data alat: {$equipment->name}");

        return redirect()->route('admin.equipments.index')->with('success', 'Alat berhasil diperbarui');
    }

    public function destroy(Equipment $equipment)
    {
        // Delete photo if exists
        if ($equipment->photo && Storage::disk('public')->exists('equipments/' . $equipment->photo)) {
            Storage::disk('public')->delete('equipments/' . $equipment->photo);
        }

        $this->logActivity(Auth::user(), "Menghapus alat: {$equipment->name}");
        $equipment->delete();

        return redirect()->route('admin.equipments.index')->with('success', 'Alat berhasil dihapus');
    }

    private function logActivity($user, $action)
    {
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'ip' => request()->ip(),
        ]);
    }
}
