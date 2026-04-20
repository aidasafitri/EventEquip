@extends('layouts.app')

@section('title', 'Edit Peminjaman - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Edit Status Peminjaman</h1>
    <p class="text-slate-600 mt-2 text-lg">Ubah status peminjaman alat</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl border border-slate-100">
    <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-slate-50 rounded-lg border border-blue-200">
        <h3 class="font-bold text-slate-900 mb-3 text-lg">📋 Informasi Peminjaman</h3>
        <p class="text-sm text-slate-700 mb-2"><strong class="text-slate-900">Peminjam:</strong> {{ $borrowing->user->name }}</p>
        <p class="text-sm text-slate-700 mb-2"><strong class="text-slate-900">Alat:</strong> {{ $borrowing->equipment->name }} ({{ $borrowing->equipment->code }})</p>
        <p class="text-sm text-slate-700 mb-2"><strong class="text-slate-900">Jumlah:</strong> {{ $borrowing->qty }}</p>
        <p class="text-sm text-slate-700"><strong class="text-slate-900">Tanggal:</strong> {{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}</p>
    </div>

    <form method="POST" action="{{ route('admin.borrowings.update', $borrowing) }}" class="space-y-7">
        @csrf
        @method('PUT')

        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status Peminjaman</label>
            <select name="status" id="status" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition">
                <option value="pending" {{ $borrowing->status === 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu Persetujuan)</option>
                <option value="approved" {{ $borrowing->status === 'approved' ? 'selected' : '' }}>✓ Approved (Disetujui)</option>
                <option value="rejected" {{ $borrowing->status === 'rejected' ? 'selected' : '' }}>✕ Rejected (Ditolak)</option>
                <option value="returned" {{ $borrowing->status === 'returned' ? 'selected' : '' }}>↩ Returned (Dikembalikan)</option>
            </select>
        </div>

        <div>
            <label for="note" class="block text-sm font-semibold text-slate-700 mb-2">Catatan (Opsional)</label>
            <textarea name="note" id="note" rows="4"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition resize-none"
                placeholder="Masukkan catatan atau keterangan">{{ old('note', $borrowing->note) }}</textarea>
        </div>

        @if ($borrowing->approver)
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                <p class="text-sm font-semibold text-emerald-900">✓ Disetujui oleh: <span class="text-emerald-700">{{ $borrowing->approver->name }}</span></p>
            </div>
        @endif

        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
                ✓ Simpan Perubahan
            </button>
            <a href="{{ route('admin.borrowings.index') }}" class="flex-1 bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-semibold text-center">
                ✕ Batal
            </a>
        </div>
    </form>
</div>
@endsection
