@extends('layouts.app')

@section('title', 'Login - EventEquip')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="inline-block bg-white rounded-full p-4 mb-4">
                <span class="text-4xl">🎉</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">EventEquip</h1>
            <p class="text-blue-100">Sistem Peminjaman Alat Event</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                    placeholder="Masukkan email Anda">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required 
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan password Anda">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                Login
            </button>

            <div class="mt-4 p-4 bg-gray-100 rounded-lg text-sm text-gray-600">
                <p class="font-semibold mb-2">Demo Login:</p>
                <ul class="space-y-1">
                    <li>📧 Admin: admin@example.com (pass: password)</li>
                    <li>📧 Petugas: petugas@example.com (pass: password)</li>
                    <li>📧 Peminjam: peminjam@example.com (pass: password)</li>
                </ul>
            </div>
        </form>

        <p class="text-center text-blue-100 text-sm">
            EventEquip © 2026 - Sistem Manajemen Peminjaman Alat Event
        </p>
    </div>
</div>
@endsection
