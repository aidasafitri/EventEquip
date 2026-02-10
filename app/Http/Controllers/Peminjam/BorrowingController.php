<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('category')
            ->where('qty_available', '>', 0)
            ->paginate(12);
        return view('peminjam.equipments.index', compact('equipments'));
    }

    public function create(Equipment $equipment)
    {
        return view('peminjam.borrowings.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'qty' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'note' => 'nullable|string',
        ]);

        $equipment = Equipment::findOrFail($validated['equipment_id']);
        if ($equipment->qty_available < $validated['qty']) {
            return back()->withErrors('Stok alat tidak cukup');
        }

        Borrowing::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('peminjam.borrowings.index')->with('success', 'Permintaan peminjaman berhasil dibuat');
    }

    public function myBorrowings()
    {
        $borrowings = Auth::user()->borrowings()
            ->with('equipment')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('peminjam.borrowings.index', compact('borrowings'));
    }

    public function return(Request $request, $id)
    {
        $borrowing = Borrowing::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($borrowing->status !== 'approved') {
            return back()->withErrors('Hanya peminjaman yang disetujui yang dapat dikembalikan');
        }

        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        return redirect()->route('peminjam.borrowings.index')->with('success', 'Alat berhasil dikembalikan');
    }
}
