@extends('layouts.app')

@section('title', 'Sunting Pengguna - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Sunting Pengguna</h1>
    <p class="text-gray-600 mt-2">Ubah data pengguna sistem EventEquip</p>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6" id="editUserForm">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                placeholder="Masukkan nama lengkap">
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                placeholder="user@example.com">
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="08xx-xxxx-xxxx">
            @error('phone')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                placeholder="Minimal 8 karakter" minlength="8">
            <p class="mt-1 text-xs text-gray-500" id="passwordHint">Biarkan kosong jika tidak ingin mengubah password</p>
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan ulang password">
            <p class="mt-1 text-xs text-red-500 hidden" id="passwordMismatch">Password tidak sama!</p>
        </div>

        <div>
    <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Role <span class="text-red-500">*</span></label>
    <div class="space-y-3">
        @foreach ($roles as $role)
            <div class="flex items-center">
                <input type="radio" name="role" value="{{ $role->id }}" id="role_{{ $role->id }}"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                    {{ $user->role_id == $role->id ? 'checked' : '' }}
                    required>
                <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-700">
                    <span class="font-medium">{{ $role->label }}</span>
                    <p class="text-xs text-gray-500">
                        @if ($role->name === 'admin')
                            Akses penuh ke sistem
                        @elseif ($role->name === 'petugas')
                            Mengelola persetujuan peminjaman dan pengembalian
                        @else
                            Dapat meminjam dan mengembalikan alat
                        @endif
                    </p>
                </label>
            </div>
        @endforeach
    </div>
    @error('role')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Ambil elemen yang diperlukan
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const mismatchMessage = document.getElementById('passwordMismatch');
    const form = document.getElementById('editUserForm');
    const passwordHint = document.getElementById('passwordHint');

    // Fungsi untuk validasi password match (hanya jika password diisi)
    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // Hanya validasi jika password tidak kosong
        if (password.length > 0) {
            if (password !== confirmPassword) {
                // Tambahkan border merah
                confirmPasswordInput.classList.add('border-red-500');
                confirmPasswordInput.classList.remove('border-gray-300');
                // Tampilkan pesan error
                mismatchMessage.classList.remove('hidden');
                return false;
            } else {
                // Hapus border merah
                confirmPasswordInput.classList.remove('border-red-500');
                confirmPasswordInput.classList.add('border-gray-300');
                // Sembunyikan pesan error
                mismatchMessage.classList.add('hidden');
                return true;
            }
        } else {
            // Jika password kosong, abaikan validasi konfirmasi
            confirmPasswordInput.classList.remove('border-red-500');
            confirmPasswordInput.classList.add('border-gray-300');
            mismatchMessage.classList.add('hidden');
            return true;
        }
    }

    // Fungsi untuk validasi password length (minimal 8 karakter)
    function validatePasswordLength() {
        const password = passwordInput.value;
        
        if (password.length > 0 && password.length < 8) {
            passwordInput.classList.add('border-red-500');
            passwordInput.classList.remove('border-gray-300');
            passwordHint.classList.remove('text-gray-500');
            passwordHint.classList.add('text-red-500');
            passwordHint.textContent = '⚠️ Password harus minimal 8 karakter!';
            return false;
        } else if (password.length >= 8) {
            passwordInput.classList.remove('border-red-500');
            passwordInput.classList.add('border-gray-300');
            passwordHint.classList.remove('text-red-500');
            passwordHint.classList.add('text-gray-500');
            passwordHint.textContent = '✓ Password valid';
            return true;
        } else {
            passwordInput.classList.remove('border-red-500');
            passwordInput.classList.add('border-gray-300');
            passwordHint.classList.remove('text-red-500');
            passwordHint.classList.add('text-gray-500');
            passwordHint.textContent = 'Biarkan kosong jika tidak ingin mengubah password';
            return true;
        }
    }

    // Fungsi untuk reset validasi saat password kosong
    function resetValidation() {
        if (passwordInput.value.length === 0) {
            confirmPasswordInput.classList.remove('border-red-500');
            confirmPasswordInput.classList.add('border-gray-300');
            mismatchMessage.classList.add('hidden');
            confirmPasswordInput.value = ''; // Kosongkan konfirmasi password
        }
    }

    // Event listener untuk validasi real-time
    passwordInput.addEventListener('input', function() {
        validatePasswordLength();
        validatePasswordMatch();
        resetValidation();
    });

    confirmPasswordInput.addEventListener('input', validatePasswordMatch);

    // Validasi sebelum submit form
    form.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        
        // Jika password diisi, lakukan validasi
        if (password.length > 0) {
            // Cek apakah password minimal 8 karakter
            if (password.length < 8) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter!');
                passwordInput.focus();
                return false;
            }
            
            // Cek apakah password dan konfirmasi sama
            if (password !== confirmPasswordInput.value) {
                e.preventDefault();
                alert('Password dan Konfirmasi Password tidak sama!');
                confirmPasswordInput.focus();
                return false;
            }
        }
        
        return true;
    });

    // Optional: Highlight tombol hapus dengan konfirmasi
    const deleteForm = document.querySelector('.confirm-delete');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm-message') || 'Apakah Anda yakin?';
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
            return true;
        });
    }
</script>

<style>
    /* Animasi smooth untuk transisi border */
    input {
        transition: all 0.3s ease;
    }
    
    /* Styling tambahan untuk pesan error */
    #passwordMismatch {
        transition: all 0.3s ease;
    }
    
    /* Efek hover untuk tombol hapus */
    .bg-red-600:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }
    
    /* Efek untuk tombol simpan */
    .bg-blue-600:hover {
        transform: translateY(-1px);
    }
    
    /* Animasi fade untuk pesan error */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #passwordMismatch:not(.hidden) {
        animation: fadeIn 0.3s ease;
    }
</style>
@endsection