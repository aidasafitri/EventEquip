@extends('layouts.app')

@section('title', 'Kelola Kategori - EventEquip')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-4xl font-bold text-slate-900">Kategori Alat</h1>
        <p class="text-slate-600 mt-2 text-lg">Manajemen kategori alat event</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
        + Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Jumlah Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($categories as $category)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-900">{{ $category->name }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm text-slate-600 font-medium">{{ Str::limit($category->description, 50) ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700">
                                {{ $category->equipments_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 transition">✎ Sunting</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline confirm-delete" data-confirm-message="Yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">🗑 Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-600 font-medium">
                            Belum ada kategori. <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:underline font-semibold">Buat kategori baru</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection
