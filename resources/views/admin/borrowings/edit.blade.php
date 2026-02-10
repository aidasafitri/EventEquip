@extends('layouts.app')

@section('title', 'Edit Peminjaman - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Edit Status Peminjaman</h1>
    <p class="text-gray-600 mt-2">Ubah status peminjaman alat</p>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <div class="mb-6 p-4 bg-gray-100 rounded-lg">
        <h3 class="font-semibold text-gray-900 mb-2">Informasi Peminjaman</h3>
        <p class="text-sm text-gray-700"><strong>Peminjam:</strong> {{ $borrowing->user->name }}</p>
        <p class="text-sm text-gray-700"><strong>Alat:</strong> {{ $borrowing->equipment->name }} ({{ $borrowing->equipment->code }})</p>
        <p class="text-sm text-gray-700"><strong>Jumlah:</strong> {{ $borrowing->qty }}</p>
        <p class="text-sm text-gray-700"><strong>Tanggal:</strong> {{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}</p>
    </div>

    <form method="POST" action="{{ route('admin.borrowings.update', $borrowing) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status Peminjaman</label>
            <select name="status" id="status" required
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="pending" {{ $borrowing->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                <option value="approved" {{ $borrowing->status === 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                <option value="rejected" {{ $borrowing->status === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                <option value="returned" {{ $borrowing->status === 'returned' ? 'selected' : '' }}>Returned (Dikembalikan)</option>
            </select>
        </div>

        <div>
            <label for="note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
            <textarea name="note" id="note" rows="4"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan catatan atau keterangan">{{ old('note', $borrowing->note) }}</textarea>
        </div>

        @if ($borrowing->approver)
            <div class="p-4 bg-blue-50 rounded-lg">
                <p class="text-sm"><strong>Disetujui oleh:</strong> {{ $borrowing->approver->name }}</p>
            </div>
        @endif

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-medium">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
