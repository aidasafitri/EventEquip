<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingReturn;
use App\Models\EquipmentDamagePrice;
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
        $borrowings = Borrowing::with(['user', 'equipment.damagePrices', 'borrowingReturn'])
            ->where('status', 'approved')
            ->orderBy('end_date')
            ->paginate(10);

        // Get unpaid fines (returned borrowings with unpaid damage)
        $unPaidFines = Borrowing::with(['user', 'equipment', 'borrowingReturn'])
            ->where('status', 'returned')
            ->whereHas('borrowingReturn', function ($query) {
                $query->where('payment_status', 'unpaid')
                      ->where('damage_amount', '>', 0);
            })
            ->orderByDesc('returned_at')
            ->paginate(10, ['*'], 'fines_page');

        return view('petugas.borrowings.monitoring', compact('borrowings', 'unPaidFines'));
    }

    public function markReturned(Request $request, $id)
    {
        try {
            $borrowing = Borrowing::findOrFail($id);

            if ($borrowing->status !== 'approved') {
                $errorMessage = 'Hanya peminjaman yang sudah disetujui yang dapat ditandai sebagai dikembalikan';

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                    ], 400);
                }
                return back()->withErrors($errorMessage);
            }

            // Validate condition and notes
            $validated = $request->validate([
                'condition' => 'required|in:baik,rusak_ringan,rusak_sedang,rusak_berat',
                'notes' => 'nullable|string|max:500',
            ]);

            // Calculate damage amount based on Equipment damage price
            $damageAmount = 0;
            if ($validated['condition'] !== 'baik') {
                // Extract damage type from condition (e.g., "rusak_ringan" => "ringan")
                $damageType = str_replace('rusak_', '', $validated['condition']);
                $damageAmount = $borrowing->equipment->getDamagePrice($damageType);
            }

            // Create BorrowingReturn record
            $borrowingReturn = BorrowingReturn::create([
                'borrowing_id' => $borrowing->id,
                'condition' => $validated['condition'],
                'notes' => $validated['notes'] ?? null,
                'damage_amount' => $damageAmount,
                'payment_status' => $damageAmount > 0 ? 'unpaid' : 'paid', // No fine = auto-paid for "baik"
                'paid_date' => $damageAmount > 0 ? null : now(),
            ]);

            // Update borrowing status
            $borrowing->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            // Increment equipment qty_available
            $equipment = $borrowing->equipment;
            $equipment->update([
                'qty_available' => $equipment->qty_available + $borrowing->qty,
            ]);

            $this->logActivity(Auth::user(), "Mencatat pengembalian alat dari {$borrowing->user->name} (Kondisi: {$borrowingReturn->getConditionLabel()}, Denda: Rp" . number_format($damageAmount, 0, ',', '.') . ")");

            // Return appropriate response based on request type
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengembalian berhasil dicatat',
                    'damage_amount' => $damageAmount,
                    'condition_label' => $borrowingReturn->getConditionLabel(),
                ]);
            }

            return redirect()->route('petugas.borrowings.monitoring')->with('success', 'Pengembalian berhasil dicatat');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            // Handle any other exceptions
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }
            throw $e;
        }
    }

    public function report()
    {
        $borrowings = Borrowing::with(['user', 'equipment', 'approver'])
            ->orderByDesc('created_at')
            ->get();

        return view('petugas.reports.borrowings', compact('borrowings'));
    }

    /**
     * Mark fine as paid for a borrowing
     */
    public function markFinePaid(Request $request, $id)
    {
        try {
            $borrowing = Borrowing::with('borrowingReturn')->findOrFail($id);

            if (!$borrowing->borrowingReturn || $borrowing->borrowingReturn->isPaid()) {
                $errorMessage = 'Denda tidak ditemukan atau sudah dibayar';

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                    ], 404);
                }
                return back()->withErrors($errorMessage);
            }

            // Update payment status
            $borrowing->borrowingReturn->update([
                'payment_status' => 'paid',
                'paid_date' => now(),
            ]);

            $this->logActivity(Auth::user(), "Mencatat pembayaran denda dari {$borrowing->user->name} (Rp" . number_format($borrowing->borrowingReturn->damage_amount, 0, ',', '.') . ")");

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Denda berhasil dilunas',
                ]);
            }

            return back()->with('success', 'Denda berhasil dilunas');
        } catch (\Exception $e) {
            // Handle any exceptions and return JSON for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }
            throw $e;
        }
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
