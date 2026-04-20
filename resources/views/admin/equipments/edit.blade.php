@extends('layouts.app')

@section('title', 'Edit Alat - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Edit Alat</h1>
    <p class="text-slate-600 mt-2 text-lg">Ubah data alat event Anda</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl border border-slate-100">
    <form method="POST" action="{{ route('admin.equipments.update', $equipment) }}" class="space-y-7" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
            <select name="category_id" id="category_id" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('category_id') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
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
            <input type="text" name="name" id="name" value="{{ old('name', $equipment->name) }}" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('name') border-red-500 @enderror"
                placeholder="Contoh: Proyektor Canon LV-7275W">
            @error('name')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="code" class="block text-sm font-semibold text-slate-700 mb-2">Kode Alat</label>
            <input type="text" name="code" id="code" value="{{ old('code', $equipment->code) }}" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('code') border-red-500 @enderror"
                placeholder="Contoh: PROJ-001">
            @error('code')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="qty_total" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Total</label>
                <input type="number" name="qty_total" id="qty_total" value="{{ old('qty_total', $equipment->qty_total) }}" required min="1"
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
                    <option value="baik" {{ old('condition', $equipment->condition) == 'baik' ? 'selected' : '' }}>✓ Baik</option>
                    <option value="rusak ringan" {{ old('condition', $equipment->condition) == 'rusak ringan' ? 'selected' : '' }}>⚠ Rusak Ringan</option>
                    <option value="rusak berat" {{ old('condition', $equipment->condition) == 'rusak berat' ? 'selected' : '' }}>✕ Rusak Berat</option>
                </select>
                @error('condition')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-50 to-slate-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-900 font-semibold">💾 Stok Saat Ini: <span class="text-blue-700">{{ $equipment->qty_available }}/{{ $equipment->qty_total }}</span></p>
        </div>

        <div>
            <label for="photo" class="block text-sm font-semibold text-slate-700 mb-3">Foto Alat (Opsional)</label>
            @if ($equipment->photo)
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                        <div>
                            <p class="text-sm font-semibold text-emerald-900">✓ Foto Saat Ini</p>
                            <p class="text-xs text-emerald-700">{{ $equipment->photo }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-blue-300 rounded-xl cursor-pointer bg-blue-50 hover:bg-blue-100 transition group">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 text-blue-500 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="text-sm text-slate-700"><span class="font-semibold">Klik untuk ganti foto</span></p>
                        <p class="text-xs text-slate-500">JPG, PNG, GIF (Maks 2MB)</p>
                    </div>
                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                </label>
            </div>
            <div id="preview" class="mt-4 hidden">
                <p class="text-sm font-semibold text-slate-700 mb-2">📸 Preview Foto Baru:</p>
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
                placeholder="Masukkan deskripsi atau spesifikasi alat">{{ old('description', $equipment->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Damage Prices Section -->
        <div class="space-y-5 border-t border-slate-200 pt-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900">💰 Pengaturan Denda Kerusakan</h3>
                <p class="text-sm text-slate-600 mt-1">Atur harga denda untuk setiap tingkat kerusakan barang</p>
            </div>

            <div class="grid grid-cols-3 gap-4">
                @php
                    $damageTypes = [
                        'ringan' => ['label' => 'Rusak Ringan', 'icon' => '⚠'],
                        'sedang' => ['label' => 'Rusak Sedang', 'icon' => '⚠⚠'],
                        'berat' => ['label' => 'Rusak Berat', 'icon' => '🔴']
                    ];
                    $damagePrices = $equipment->damagePrices->keyBy('damage_type')->toArray() ?? [];
                @endphp

                @foreach ($damageTypes as $typeKey => $typeData)
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 hover:border-blue-300 transition">
                        <label for="damage_prices_{{ $typeKey }}" class="block text-sm font-semibold text-slate-700 mb-3">
                            {{ $typeData['icon'] }} {{ $typeData['label'] }}
                        </label>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-600 font-medium">Rp</span>
                            <input type="number"
                                name="damage_prices[{{ $typeKey }}]"
                                id="damage_prices_{{ $typeKey }}"
                                value="{{ old('damage_prices.' . $typeKey, $damagePrices[$typeKey]['price'] ?? match($typeKey) {
                                    'ringan' => 20000,
                                    'sedang' => 50000,
                                    'berat' => 100000,
                                    default => 0
                                }) }}"
                                step="1000"
                                min="0"
                                class="flex-1 px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white @error('damage_prices.' . $typeKey) border-red-500 @enderror"
                                placeholder="0">
                        </div>
                        @error('damage_prices.' . $typeKey)
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
                ✓ Simpan Perubahan
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
