<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'equipment', 'approver'])->orderByDesc('created_at')->paginate(10);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function edit(Borrowing $borrowing)
    {
        return view('admin.borrowings.edit', compact('borrowing'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,returned',
            'note' => 'nullable|string',
        ]);

        $borrowing->update([
            'status' => $validated['status'],
            'note' => $validated['note'],
        ]);

        if ($validated['status'] === 'approved' && !$borrowing->approved_by) {
            $borrowing->update(['approved_by' => Auth::id()]);
        }

        if ($validated['status'] === 'returned') {
            $borrowing->update(['returned_at' => now()]);
            $equipment = $borrowing->equipment;
            $equipment->update([
                'qty_available' => $equipment->qty_available + $borrowing->qty,
            ]);
        }

        $this->logActivity(Auth::user(), "Mengubah status peminjaman ID {$borrowing->id} menjadi {$validated['status']}");

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->withErrors('Hanya peminjaman dengan status pending yang dapat dihapus');
        }

        $this->logActivity(Auth::user(), "Menghapus peminjaman ID {$borrowing->id}");
        $borrowing->delete();

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil dihapus');
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
