<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        Equipment::create([
            ...$validated,
            'qty_available' => $validated['qty_total'],
        ]);

        $this->logActivity(Auth::user(), "Membuat alat baru: {$validated['name']}");

        return redirect()->route('admin.equipments.index')->with('success', 'Alat berhasil dibuat');
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::all();
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
        ]);

        $equipment->update($validated);

        $this->logActivity(Auth::user(), "Mengubah data alat: {$equipment->name}");

        return redirect()->route('admin.equipments.index')->with('success', 'Alat berhasil diperbarui');
    }

    public function destroy(Equipment $equipment)
    {
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
