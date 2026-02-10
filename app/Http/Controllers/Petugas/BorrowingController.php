<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'equipment'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('petugas.borrowings.index', compact('borrowings'));
    }

    public function approve(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'pending') {
            return back()->withErrors('Hanya peminjaman pending yang dapat disetujui');
        }

        $equipment = $borrowing->equipment;
        if ($equipment->qty_available < $borrowing->qty) {
            return back()->withErrors('Stok alat tidak cukup');
        }

        $borrowing->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
        ]);

        $equipment->update([
            'qty_available' => $equipment->qty_available - $borrowing->qty,
        ]);

        $this->logActivity(Auth::user(), "Menyetujui peminjaman dari {$borrowing->user->name}");

        return redirect()->route('petugas.borrowings.index')->with('success', 'Peminjaman berhasil disetujui');
    }

    public function monitoringReturns()
    {
        $borrowings = Borrowing::with(['user', 'equipment'])
            ->where('status', 'approved')
            ->orderBy('end_date')
            ->paginate(10);

        return view('petugas.borrowings.monitoring', compact('borrowings'));
    }

    public function markReturned(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'approved') {
            return back()->withErrors('Hanya peminjaman yang sudah disetujui yang dapat ditandai sebagai dikembalikan');
        }

        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        $equipment = $borrowing->equipment;
        $equipment->update([
            'qty_available' => $equipment->qty_available + $borrowing->qty,
        ]);

        $this->logActivity(Auth::user(), "Mencatat pengembalian alat dari {$borrowing->user->name}");

        return redirect()->route('petugas.borrowings.monitoring')->with('success', 'Pengembalian berhasil dicatat');
    }

    public function report()
    {
        $borrowings = Borrowing::with(['user', 'equipment', 'approver'])
            ->orderByDesc('created_at')
            ->get();

        return view('petugas.reports.borrowings', compact('borrowings'));
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
