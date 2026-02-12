@extends('layouts.app')

@section('title', 'Daftar - EventEquip')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-2">EventEquip</h1>
            <p class="text-blue-100">Sistem Peminjaman Alat Event</p>
        </div>

        <form method="POST" action="{{ route('register.perform') }}" class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            @csrf

            <h2 class="text-2xl font-semibold mb-2 text-center">Daftar Peminjam</h2>

            @if(session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="mb-4">
                    <ul class="text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required minlength="8" maxlength="20" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required minlength="8" maxlength="20" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium">Daftar</button>

            <div class="text-center mt-2">
                <p class="text-sm text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-blue-600">Login</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
