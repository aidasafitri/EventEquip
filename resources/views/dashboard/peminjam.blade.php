@extends('layouts.app')

@section('title', 'Dashboard Peminjam - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Peminjam</h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                <span class="text-2xl">📦</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Peminjaman</p>
                <p class="text-3xl font-bold text-blue-600">{{ $myBorrowings }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                <span class="text-2xl">⏳</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Menunggu Persetujuan</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pending }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                <span class="text-2xl">✅</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Peminjaman Aktif</p>
                <p class="text-3xl font-bold text-green-600">{{ $approved }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Unpaid Fines Alert Section -->
@if ($unpaidFines->count() > 0)
<div class="mb-8 bg-red-50 border-2 border-red-300 rounded-lg p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <span class="text-3xl">⚠️</span>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-bold text-red-900">Perhatian: Ada Denda yang Belum Dibayar</h3>
            <p class="text-red-800 mt-2">Anda memiliki <strong>{{ $unpaidFines->count() }} denda </strong> yang belum dibayar dari pengembalian alat yang rusak.</p>

            <div class="mt-4 space-y-3">
                @foreach ($unpaidFines as $borrowing)
                <div class="bg-white rounded-lg p-4 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $borrowing->equipment->name }}</p>
                            <p class="text-sm text-gray-600">Kondisi: <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-orange-100 text-orange-800">{{ $borrowing->borrowingReturn->getConditionLabel() }}</span></p>
                            @if ($borrowing->borrowingReturn->notes)
                            <p class="text-sm text-gray-600 mt-1">Catatan: {{ $borrowing->borrowingReturn->notes }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($borrowing->getFineAmount(), 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Denda yang harus dibayar</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 bg-red-100 border border-red-300 rounded-lg p-4">
                <p class="text-red-900 font-semibold">Total Denda: <span class="text-2xl">Rp {{ number_format($totalUnpaidAmount, 0, ',', '.') }}</span></p>
                <p class="text-sm text-red-700 mt-2">Segera lakukan pembayaran untuk melanjutkan peminjaman. Hubungi petugas untuk memproses pembayaran denda Anda.</p>
            </div>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Menu Peminjaman</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('peminjam.equipments.index') }}" class="block p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg hover:shadow-lg transition border-l-4 border-blue-600">
                <div class="text-3xl mb-3">🔍</div>
                <p class="font-bold text-gray-900 text-lg">Lihat Daftar Alat</p>
                <p class="text-sm text-gray-600 mt-1">Jelajahi semua alat yang tersedia untuk dipinjam</p>
            </a>

            <a href="{{ route('peminjam.borrowings.index') }}" class="block p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-lg hover:shadow-lg transition border-l-4 border-green-600">
                <div class="text-3xl mb-3">📋</div>
                <p class="font-bold text-gray-900 text-lg">Peminjaman Saya</p>
                <p class="text-sm text-gray-600 mt-1">Kelola peminjaman dan pengembalian alat</p>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Panduan Langkah Demi Langkah</h2>
        <div class="space-y-3">
            <div class="flex items-start">
                <span class="text-2xl mr-3">1️⃣</span>
                <div>
                    <p class="font-medium text-gray-900">Lihat Daftar Alat</p>
                    <p class="text-sm text-gray-500">Kunjungi halaman "Lihat Daftar Alat" untuk melihat semua alat yang tersedia</p>
                </div>
            </div>
            <div class="flex items-start">
                <span class="text-2xl mr-3">2️⃣</span>
                <div>
                    <p class="font-medium text-gray-900">Ajukan Peminjaman</p>
                    <p class="text-sm text-gray-500">Pilih alat yang ingin dipinjam dan isi form permintaan peminjaman</p>
                </div>
            </div>
            <div class="flex items-start">
                <span class="text-2xl mr-3">3️⃣</span>
                <div>
                    <p class="font-medium text-gray-900">Tunggu Persetujuan</p>
                    <p class="text-sm text-gray-500">Petugas akan memeriksa dan menyetujui permintaan Anda</p>
                </div>
            </div>
            <div class="flex items-start">
                <span class="text-2xl mr-3">4️⃣</span>
                <div>
                    <p class="font-medium text-gray-900">Kembalikan Alat</p>
                    <p class="text-sm text-gray-500">Kembalikan alat sesuai jadwal dan tandai sebagai dikembalikan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Tips Penting</h2>
        <div class="space-y-2 text-sm">
            <div class="flex items-start">
                <span class="text-yellow-500 mr-2">⚠️</span>
                <p class="text-gray-700">Pastikan tanggal pengembalian sudah sesuai dengan kebutuhan Anda</p>
            </div>
            <div class="flex items-start">
                <span class="text-green-500 mr-2">✓</span>
                <p class="text-gray-700">Periksa kondisi alat sebelum dan sesudah peminjaman</p>
            </div>
            <div class="flex items-start">
                <span class="text-blue-500 mr-2">ℹ️</span>
                <p class="text-gray-700">Kembalikan alat tepat waktu untuk menghindari denda</p>
            </div>
        </div>
    </div>
</div>
@endsection
