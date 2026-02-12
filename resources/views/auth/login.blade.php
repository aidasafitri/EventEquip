@extends('layouts.app')

@section('title', 'Login - EventEquip')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
           
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

          

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                Login
            </button>
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">Belum Punya Akun? <a href="{{ route('register.show') }}" class="font-semibold text-blue-600">Daftar</a></p>
            </div>

        </form>

        
    </div>
</div>
@endsection
