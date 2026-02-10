@extends('layouts.app')

@section('title', 'Dashboard Admin - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                <span class="text-2xl">👥</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total User</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                <span class="text-2xl">🛠️</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Alat</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalEquipment }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                <span class="text-2xl">📋</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Peminjaman</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBorrowings }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                <span class="text-2xl">⏳</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Peminjaman Pending</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingBorrowings }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Manajemen</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.users.index') }}" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <div class="text-2xl mb-2">👥</div>
                <p class="font-medium text-gray-900">Kelola User</p>
                <p class="text-xs text-gray-500">Tambah, edit, hapus user</p>
            </a>

            <a href="{{ route('admin.equipments.index') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <div class="text-2xl mb-2">🛠️</div>
                <p class="font-medium text-gray-900">Kelola Alat</p>
                <p class="text-xs text-gray-500">Kelola inventori alat</p>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="block p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                <div class="text-2xl mb-2">📁</div>
                <p class="font-medium text-gray-900">Kategori Alat</p>
                <p class="text-xs text-gray-500">Kelola kategori</p>
            </a>

            <a href="{{ route('admin.borrowings.index') }}" class="block p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                <div class="text-2xl mb-2">📋</div>
                <p class="font-medium text-gray-900">Data Peminjaman</p>
                <p class="text-xs text-gray-500">Lihat semua peminjaman</p>
            </a>

            <a href="{{ route('admin.activity-logs.index') }}" class="block p-4 bg-red-50 rounded-lg hover:bg-red-100 transition">
                <div class="text-2xl mb-2">📝</div>
                <p class="font-medium text-gray-900">Log Aktivitas</p>
                <p class="text-xs text-gray-500">Pantau aktivitas sistem</p>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Info Sistem</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between padding-3 bg-gray-50 rounded p-3">
                <span class="text-gray-600">Status Sistem</span>
                <span class="text-green-600 font-semibold">✓ Aktif</span>
            </div>
            <div class="flex items-center justify-between padding-3 bg-gray-50 rounded p-3">
                <span class="text-gray-600">Versi</span>
                <span class="text-gray-900 font-semibold">1.0.0</span>
            </div>
            <div class="flex items-center justify-between padding-3 bg-gray-50 rounded p-3">
                <span class="text-gray-600">Database</span>
                <span class="text-gray-900 font-semibold">Connected</span>
            </div>
            <div class="flex items-center justify-between padding-3 bg-gray-50 rounded p-3">
                <span class="text-gray-600">User Login</span>
                <span class="text-gray-900 font-semibold">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
