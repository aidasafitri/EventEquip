@extends('layouts.app')

@section('title', 'Setujui Peminjaman - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Setujui Peminjaman</h1>
    <p class="text-gray-600 mt-2">Proses persetujuan permintaan peminjaman alat</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($borrowings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Peminjaman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $borrowing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->user->phone ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $borrowing->equipment->name }}</p>
                                <p class="text-xs text-gray-500">Stok: {{ $borrowing->equipment->qty_available }}/{{ $borrowing->equipment->qty_total }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $borrowing->qty }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form method="POST" action="{{ route('petugas.borrowings.approve', $borrowing->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                        Setujui
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            {{ $borrowings->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <div class="text-5xl mb-4">✅</div>
            <p class="text-gray-500 text-lg">Tidak ada peminjaman yang menunggu persetujuan</p>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mt-2 inline-block">Kembali ke Dashboard</a>
        </div>
    @endif
</div>
@endsection
