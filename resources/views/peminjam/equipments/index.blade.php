@extends('layouts.app')

@section('title', 'Daftar Alat - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Daftar Alat Tersedia</h1>
    <p class="text-slate-600 mt-2 text-lg">Jelajahi dan pilih alat yang ingin dipinjam untuk acara Anda</p>
</div>

@if ($equipments->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($equipments as $equipment)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden flex flex-col group border border-slate-100">
                <!-- Image Container -->
                <div class="bg-slate-100 h-24 overflow-hidden flex items-center justify-center relative">
                    <img src="{{ $equipment->getPhotoUrl() }}" alt="{{ $equipment->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    @if ($equipment->qty_available <= 0)
                        <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center backdrop-blur-sm">
                            <span class="text-white font-bold text-lg">✕ Stok Habis</span>
                        </div>
                    @endif
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $equipment->name }}</h3>
                    
                    <div class="mb-4">
                        <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">
                            {{ $equipment->category->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="mb-4 flex items-center justify-between">
                        <p class="text-xs text-slate-700 uppercase font-bold tracking-wider">Kode Alat</p>
                        <code class="text-sm bg-slate-100 px-3 py-1 rounded-lg font-mono text-slate-700 font-semibold border border-slate-200">{{ $equipment->code }}</code>
                    </div>

                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Ketersediaan</span>
                            <span class="text-sm font-bold text-slate-900">{{ $equipment->qty_available }}/{{ $equipment->qty_total }}</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-2.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all" 
                                style="width: {{ ($equipment->qty_available / $equipment->qty_total) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-slate-700 uppercase font-bold tracking-wider mb-2">Kondisi Barang</p>
                        <span class="inline-flex px-3 py-1.5 text-xs font-bold rounded-full
                            @if ($equipment->condition === 'baik') bg-emerald-100 text-emerald-800
                            @elseif ($equipment->condition === 'rusak ringan') bg-amber-100 text-amber-800
                            @else bg-rose-100 text-rose-800 @endif">
                            @if ($equipment->condition === 'baik') ✓ @elseif ($equipment->condition === 'rusak ringan') ⚠ @else ✕ @endif
                            {{ $equipment->condition }}
                        </span>
                    </div>

                    @if ($equipment->description)
                        <p class="text-sm text-slate-600 mb-5 flex-1 line-clamp-2">{{ $equipment->description }}</p>
                    @endif

                    @if ($equipment->qty_available > 0)
                        <a href="{{ route('peminjam.borrowing.create', $equipment) }}" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Ajukan Peminjaman
                        </a>
                    @else
                        <button disabled class="w-full bg-slate-200 text-slate-600 py-3 rounded-lg text-center font-semibold cursor-not-allowed opacity-60">
                            ✕ Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $equipments->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-slate-100">
        <div class="text-6xl mb-4">📭</div>
        <p class="text-slate-600 text-lg font-medium">Belum ada alat yang tersedia untuk dipinjam</p>
    </div>
@endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
