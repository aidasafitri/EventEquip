<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;
use App\Models\Equipment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isPetugas()) {
            return $this->petugasDashboard();
        } elseif ($user->isPeminjam()) {
            return $this->peminjamDashboard();
        }

        return redirect('/');
    }

    private function adminDashboard()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalEquipment' => Equipment::count(),
            'totalBorrowings' => Borrowing::count(),
            'pendingBorrowings' => Borrowing::where('status', 'pending')->count(),
        ];

        return view('dashboard.admin', $data);
    }

    private function petugasDashboard()
    {
        $data = [
            'pendingBorrowings' => Borrowing::where('status', 'pending')->count(),
            'unreturned' => Borrowing::where('status', 'approved')->where('end_date', '<', today())->count(),
        ];

        return view('dashboard.petugas', $data);
    }

    private function peminjamDashboard()
    {
        $user = Auth::user();

        // Get borrowings dengan return info
        $borrowings = $user->borrowings()
            ->with(['equipment', 'borrowingReturn'])
            ->orderByDesc('created_at')
            ->get();

        // Calculate fine stats using foreach untuk safety
        $unpaidFines = collect();
        $totalUnpaidAmount = 0;

        foreach ($borrowings as $borrowing) {
            if ($borrowing->hasUnpaidFine()) {
                $unpaidFines->push($borrowing);
                $totalUnpaidAmount += $borrowing->getFineAmount();
            }
        }

        $data = [
            'myBorrowings' => $borrowings->count(),
            'pending' => $borrowings->where('status', 'pending')->count(),
            'approved' => $borrowings->where('status', 'approved')->count(),
            'returned' => $borrowings->where('status', 'returned')->count(),
            'borrowings' => $borrowings,
            'unpaidFines' => $unpaidFines,
            'totalUnpaidAmount' => $totalUnpaidAmount,
        ];

        return view('dashboard.peminjam', $data);
    }
}
