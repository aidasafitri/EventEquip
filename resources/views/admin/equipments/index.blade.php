@extends('layouts.app')

@section('title', 'Kelola Alat - EventEquip')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold text-slate-900">Kelola Alat</h1>
            <p class="text-slate-600 mt-2 text-lg">Manajemen inventori alat event</p>
        </div>
        <a href="{{ route('admin.equipments.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2 w-full md:w-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Alat
        </a>
    </div>
</div>

@if ($equipments->count() > 0)
    <!-- Grid View for Larger Screens -->
    <div class="hidden lg:grid gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 mb-8">
        @foreach ($equipments as $equipment)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden group flex flex-col border border-slate-100">
                <!-- Image Container -->
                <div class="relative bg-slate-100 h-48 overflow-hidden flex items-center justify-center">
                    <img src="{{ $equipment->getPhotoUrl() }}" alt="{{ $equipment->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300 max-h-48">
                    <div class="absolute top-3 right-3 flex gap-2">
                        <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full
                            @if ($equipment->condition === 'baik') bg-emerald-100 text-emerald-800
                            @elseif ($equipment->condition === 'rusak ringan') bg-amber-100 text-amber-800
                            @else bg-rose-100 text-rose-800 @endif">
                            @if ($equipment->condition === 'baik') ✓ @elseif ($equipment->condition === 'rusak ringan') ⚠ @else ✕ @endif
                            {{ $equipment->condition }}
                        </span>
                    </div>
                </div>

                <!-- Content Container -->
                <div class="p-5 flex flex-col flex-grow">
                    <!-- Code Badge -->
                    <div class="mb-3">
                        <span class="inline-flex px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">
                            {{ $equipment->code }}
                        </span>
                    </div>

                    <!-- Equipment Name -->
                    <h3 class="text-lg font-bold text-slate-900 mb-1 line-clamp-2">{{ $equipment->name }}</h3>

                    <!-- Category -->
                    <p class="text-sm text-slate-600 mb-4">{{ $equipment->category->name ?? '-' }}</p>

                    <!-- Stock Bar -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-semibold text-slate-700">Stok Tersedia</span>
                            <span class="text-sm font-bold text-slate-900">{{ $equipment->qty_available }}/{{ $equipment->qty_total }}</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-2.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all" 
                                style="width: {{ ($equipment->qty_available / $equipment->qty_total) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Description (if exists) -->
                    @if ($equipment->description)
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $equipment->description }}</p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-2 mt-auto">
                        <a href="{{ route('admin.equipments.edit', $equipment) }}" class="flex-1 bg-blue-50 text-blue-700 hover:bg-blue-100 px-4 py-2.5 rounded-lg transition text-sm font-semibold text-center border border-blue-200">
                            ✎ Sunting
                        </a>
                        <form method="POST" action="{{ route('admin.equipments.destroy', $equipment) }}" class="flex-1 confirm-delete" data-confirm-message="Yakin ingin menghapus alat ini? Tindakan ini tidak dapat dibatalkan.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-700 hover:bg-red-100 px-4 py-2.5 rounded-lg transition text-sm font-semibold border border-red-200">
                                🗑 Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Table View for Tablet and Mobile -->
    <div class="lg:hidden bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Alat</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Stok</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach ($equipments as $equipment)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <img src="{{ $equipment->getPhotoUrl() }}" alt="{{ $equipment->name }}" class="h-12 w-12 object-cover rounded-lg shadow-sm">
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-semibold text-slate-900">{{ $equipment->name }}</div>
                                <div class="text-xs text-slate-600 font-medium">{{ $equipment->code }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $equipment->qty_available }}/{{ $equipment->qty_total }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold space-x-2">
                                <a href="{{ route('admin.equipments.edit', $equipment) }}" class="text-blue-600 hover:text-blue-800 transition">✎ Sunting</a>
                                <form method="POST" action="{{ route('admin.equipments.destroy', $equipment) }}" class="inline confirm-delete" data-confirm-message="Yakin ingin menghapus alat ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">🗑 Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $equipments->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-slate-100">
        <div class="text-6xl mb-4">📦</div>
        <h3 class="text-2xl font-bold text-slate-900 mb-3">Belum Ada Alat</h3>
        <p class="text-slate-600 mb-8 text-lg">Mulai tambahkan alat ke sistem inventori Anda</p>
        <a href="{{ route('admin.equipments.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
            + Tambah Alat Pertama
        </a>
    </div>
@endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.confirm-delete {
    display: inline;
}

.confirm-delete button:hover {
    text-decoration: underline;
}
</style>

<script>
document.querySelectorAll('.confirm-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        const message = this.getAttribute('data-confirm-message') || 'Yakin ingin melanjutkan?';
        if (!confirm(message)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
