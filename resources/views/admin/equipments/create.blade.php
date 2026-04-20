@extends('layouts.app')

@section('title', 'Tambah Alat Baru - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Tambah Alat Baru</h1>
    <p class="text-slate-600 mt-2 text-lg">Daftarkan alat event baru ke sistem</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl border border-slate-100">
    <form method="POST" action="{{ route('admin.equipments.store') }}" class="space-y-7" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
            <select name="category_id" id="category_id" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('category_id') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Alat</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('name') border-red-500 @enderror"
                placeholder="Contoh: Proyektor Canon LV-7275W">
            @error('name')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="code" class="block text-sm font-semibold text-slate-700 mb-2">Kode Alat</label>
            <input type="text" name="code" id="code" value="{{ old('code') }}" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('code') border-red-500 @enderror"
                placeholder="Contoh: PROJ-001">
            @error('code')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="qty_total" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Total</label>
                <input type="number" name="qty_total" id="qty_total" value="{{ old('qty_total', 1) }}" required min="1"
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('qty_total') border-red-500 @enderror">
                @error('qty_total')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="condition" class="block text-sm font-semibold text-slate-700 mb-2">Kondisi</label>
                <select name="condition" id="condition" required
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('condition') border-red-500 @enderror">
                    <option value="">Pilih Kondisi</option>
                    <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>✓ Baik</option>
                    <option value="rusak ringan" {{ old('condition') == 'rusak ringan' ? 'selected' : '' }}>⚠ Rusak Ringan</option>
                    <option value="rusak berat" {{ old('condition') == 'rusak berat' ? 'selected' : '' }}>✕ Rusak Berat</option>
                </select>
                @error('condition')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="photo" class="block text-sm font-semibold text-slate-700 mb-3">Foto Alat (Opsional)</label>
            <div class="mt-2 flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-blue-300 rounded-xl cursor-pointer bg-blue-50 hover:bg-blue-100 transition group">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 text-blue-500 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="text-sm text-slate-700"><span class="font-semibold">Klik untuk upload</span></p>
                        <p class="text-xs text-slate-500">JPG, PNG, GIF (Maks 2MB)</p>
                    </div>
                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                </label>
            </div>
            <div id="preview" class="mt-4 hidden">
                <p class="text-sm font-semibold text-slate-700 mb-2">Preview Foto:</p>
                <img id="previewImg" src="" alt="Preview" class="h-32 object-cover rounded-lg shadow-md">
            </div>
            @error('photo')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition resize-none"
                placeholder="Masukkan deskripsi atau spesifikasi alat">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
                ✓ Simpan Alat
            </button>
            <a href="{{ route('admin.equipments.index') }}" class="flex-1 bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-semibold text-center">
                ✕ Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
