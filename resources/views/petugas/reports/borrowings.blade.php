@extends('layouts.app')

@section('title', 'Laporan Peminjaman - EventEquip')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Laporan Peminjaman</h1>
            <p class="text-gray-600 mt-2">Laporan lengkap semua peminjaman alat</p>
        </div>
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
            🖨️ Cetak Laporan
        </button>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-8">
    <div class="mb-6 border-b pb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-2">EventEquip - Laporan Peminjaman</h2>
        <p class="text-sm text-gray-600">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Awal Pinjam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akhir Pinjam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dikembalikan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disetujui Oleh</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($borrowings as $key => $borrowing)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $key + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $borrowing->user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $borrowing->equipment->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $borrowing->qty }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $borrowing->start_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $borrowing->end_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $borrowing->returned_at ? $borrowing->returned_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if ($borrowing->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif ($borrowing->status === 'approved') bg-blue-100 text-blue-800
                                @elseif ($borrowing->status === 'rejected') bg-red-100 text-red-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $borrowing->approver->name ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-3 text-center text-gray-500">
                            Tidak ada data peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 pt-6 border-t text-sm text-gray-600">
        <p>Total Peminjaman: <strong>{{ $borrowings->count() }}</strong></p>
        <p>Peminjaman Approved: <strong>{{ $borrowings->where('status', 'approved')->count() }}</strong></p>
        <p>Peminjaman Returned: <strong>{{ $borrowings->where('status', 'returned')->count() }}</strong></p>
    </div>
</div>

<style media="print">
    body { background: white; }
    .no-print { display: none; }
</style>
@endsection
