@extends('layouts.app')

@section('title', 'Tambah User Baru - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Tambah User Baru</h1>
    <p class="text-slate-600 mt-2 text-lg">Buat akun pengguna sistem EventEquip</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl border border-slate-100">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-7" id="userForm">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('name') border-red-500 @enderror"
                placeholder="Masukkan nama lengkap">
            @error('name')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('email') border-red-500 @enderror"
                placeholder="user@example.com">
            @error('email')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition"
                placeholder="08xx-xxxx-xxxx">
            @error('phone')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition @error('password') border-red-500 @enderror"
                placeholder="Minimal 8 karakter" minlength="8">
            <p class="mt-2 text-xs text-slate-600 font-medium" id="passwordHint">📝 Minimal 8 karakter</p>
            @error('password')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 hover:bg-white transition"
                placeholder="Masukkan ulang password">
            <p class="mt-2 text-xs text-red-600 font-medium hidden" id="passwordMismatch">⚠️ Password tidak sama!</p>
        </div>

        {{-- PERUBAHAN PENTING: name="role" bukan "roles" --}}
        <div class="border-t border-slate-200 pt-6">
            <label class="block text-sm font-semibold text-slate-700 mb-4">Pilih Role <span class="text-red-500">*</span></label>
            <div class="space-y-3">
                @foreach ($roles as $role)
                    <div class="flex items-center p-3 rounded-lg border border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition cursor-pointer">
                        <input type="radio" name="role" value="{{ $role->id }}" id="role_{{ $role->id }}"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300"
                            {{ old('role') == $role->id ? 'checked' : '' }}
                            required>
                        <label for="role_{{ $role->id }}" class="ml-3 block text-sm cursor-pointer flex-1">
                            <span class="font-semibold text-slate-900">{{ $role->label }}</span>
                            <p class="text-xs text-slate-600 mt-1">
                                @if ($role->name === 'admin')
                                    🔐 Akses penuh ke sistem
                                @elseif ($role->name === 'petugas')
                                    👤 Mengelola persetujuan peminjaman dan pengembalian
                                @else
                                    📦 Dapat meminjam dan mengembalikan alat
                                @endif
                            </p>
                        </label>
                    </div>
                @endforeach
            </div>
            @error('role')
                <p class="mt-3 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
                ✓ Simpan User
            </button>
            <a href="{{ route('admin.users.index') }}" class="flex-1 bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-semibold text-center">
                ✕ Batal
            </a>
        </div>
    </form>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const mismatchMessage = document.getElementById('passwordMismatch');
    const form = document.getElementById('userForm');

    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword.length > 0 && password !== confirmPassword) {
            confirmPasswordInput.classList.add('border-red-500');
            confirmPasswordInput.classList.remove('border-slate-200');
            mismatchMessage.classList.remove('hidden');
            return false;
        } else {
            confirmPasswordInput.classList.remove('border-red-500');
            confirmPasswordInput.classList.add('border-slate-200');
            mismatchMessage.classList.add('hidden');
            return true;
        }
    }

    function validatePasswordLength() {
        const password = passwordInput.value;
        const passwordHint = document.getElementById('passwordHint');
        
        if (password.length > 0 && password.length < 8) {
            passwordInput.classList.add('border-red-500');
            passwordInput.classList.remove('border-slate-200');
            passwordHint.classList.remove('text-slate-600');
            passwordHint.classList.add('text-red-600');
            passwordHint.textContent = '⚠️ Password harus minimal 8 karakter!';
            return false;
        } else if (password.length >= 8) {
            passwordInput.classList.remove('border-red-500');
            passwordInput.classList.add('border-slate-200');
            passwordHint.classList.remove('text-red-600');
            passwordHint.classList.add('text-slate-600');
            passwordHint.textContent = '✓ Password valid';
            return true;
        } else {
            passwordInput.classList.remove('border-red-500');
            passwordInput.classList.add('border-slate-200');
            passwordHint.classList.remove('text-red-600');
            passwordHint.classList.add('text-slate-600');
            passwordHint.textContent = '📝 Minimal 8 karakter';
            return true;
        }
    }

    passwordInput.addEventListener('input', function() {
        validatePasswordLength();
        validatePasswordMatch();
    });

    confirmPasswordInput.addEventListener('input', validatePasswordMatch);

    form.addEventListener('submit', function(e) {
        const isPasswordValid = validatePasswordLength();
        const isMatchValid = validatePasswordMatch();
        
        if (passwordInput.value.length < 8) {
            e.preventDefault();
            alert('Password harus minimal 8 karakter!');
            passwordInput.focus();
            return false;
        }
        
        if (passwordInput.value !== confirmPasswordInput.value) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama!');
            confirmPasswordInput.focus();
            return false;
        }
        
        // PERUBAHAN: selector untuk role (name="role")
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (!selectedRole) {
            e.preventDefault();
            alert('Silakan pilih role untuk user!');
            return false;
        }
        
        return true;
    });
</script>

<style>
    input {
        transition: all 0.3s ease;
    }
    
    #passwordMismatch {
        transition: all 0.3s ease;
    }
    
    input[type="radio"] {
        cursor: pointer;
    }
    
    input[type="radio"]:checked {
        accent-color: #3b82f6;
    }
</style>
@endsection