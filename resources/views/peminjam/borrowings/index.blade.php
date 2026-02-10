@extends('layouts.app')

@section('title', 'Peminjaman Saya - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Peminjaman Saya</h1>
    <p class="text-gray-600 mt-2">Lihat dan kelola semua peminjaman alat Anda</p>
</div>

@if ($borrowings->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Total Peminjaman</p>
            <p class="text-3xl font-bold text-gray-900">{{ $borrowings->total() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Menunggu Persetujuan</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $borrowings->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Sedang Dipinjam</p>
            <p class="text-3xl font-bold text-blue-600">{{ $borrowings->where('status', 'approved')->count() }}</p>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($borrowings as $borrowing)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="border-l-4 @if ($borrowing->status === 'pending') border-yellow-500
                    @elseif ($borrowing->status === 'approved') border-blue-500
                    @elseif ($borrowing->status === 'returned') border-green-500
                    @else border-red-500 @endif">
                    <div class="p-6">
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $borrowing->equipment->name }}</h3>
                                <p class="text-sm text-gray-500">Kode: {{ $borrowing->equipment->code }}</p>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                @if ($borrowing->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif ($borrowing->status === 'approved') bg-blue-100 text-blue-800
                                @elseif ($borrowing->status === 'returned') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                @if ($borrowing->status === 'pending')
                                    ⏳ Menunggu Persetujuan
                                @elseif ($borrowing->status === 'approved')
                                    ✅ Disetujui
                                @elseif ($borrowing->status === 'returned')
                                    ✓ Dikembalikan
                                @else
                                    ❌ Ditolak
                                @endif
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Jumlah</p>
                                <p class="font-semibold text-gray-900">{{ $borrowing->qty }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Mulai</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($borrowing->start_date)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Akhir</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($borrowing->end_date)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Diajukan</p>
                                <p class="font-semibold text-gray-900">{{ $borrowing->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        @if ($borrowing->note)
                            <div class="mb-4 p-3 bg-gray-50 rounded">
                                <p class="text-xs text-gray-500 uppercase">Keterangan</p>
                                <p class="text-sm text-gray-700">{{ $borrowing->note }}</p>
                            </div>
                        @endif

                        <div class="flex gap-2">
                            @if ($borrowing->status === 'approved')
                                <form method="POST" action="{{ route('peminjam.borrowing.return', $borrowing->id) }}" class="inline" onsubmit="return confirm('Yakin alat sudah dikembalikan?');">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                        Kembalikan Alat
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $borrowings->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <div class="text-5xl mb-4">📭</div>
        <p class="text-gray-500 text-lg mb-4">Anda belum memiliki peminjaman</p>
        <a href="{{ route('peminjam.equipments.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
            Lihat Daftar Alat
        </a>
    </div>
@endif
@endsection
