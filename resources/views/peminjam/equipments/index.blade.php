@extends('layouts.app')

@section('title', 'Daftar Alat - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Daftar Alat Tersedia</h1>
    <p class="text-gray-600 mt-2">Jelajahi dan pilih alat yang ingin dipinjam</p>
</div>

@if ($equipments->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($equipments as $equipment)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden flex flex-col">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32 flex items-center justify-center">
                    <div class="text-5xl">🛠️</div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $equipment->name }}</h3>
                    
                    <div class="mb-4">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $equipment->category->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Kode Alat</p>
                        <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $equipment->code }}</code>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Ketersediaan</p>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full">
                                <div class="h-2 bg-green-500 rounded-full" style="width: {{ ($equipment->qty_available / $equipment->qty_total) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $equipment->qty_available }}/{{ $equipment->qty_total }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Kondisi</p>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                            @if ($equipment->condition === 'baik') bg-green-100 text-green-800
                            @elseif ($equipment->condition === 'rusak ringan') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $equipment->condition }}
                        </span>
                    </div>

                    @if ($equipment->description)
                        <p class="text-sm text-gray-600 mb-4 flex-1">{{ $equipment->description }}</p>
                    @endif

                    @if ($equipment->qty_available > 0)
                        <a href="{{ route('peminjam.borrowing.create', $equipment) }}" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-center font-medium">
                            Ajukan Peminjaman
                        </a>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-2 rounded-lg text-center font-medium cursor-not-allowed">
                            Stok Habis
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
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <div class="text-5xl mb-4">📭</div>
        <p class="text-gray-500 text-lg">Belum ada alat yang tersedia untuk dipinjam</p>
    </div>
@endif
@endsection
