<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventEquip - Sistem Peminjaman Alat Event')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50">
    @auth
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <div class="flex-shrink-0 flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg">
                                <span class="text-xl font-bold">EventEquip</span>
                            </div>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex h-screen bg-gray-100 pt-16">
            @include('layouts.sidebar')

            <main class="flex-1 overflow-y-auto">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    <!-- Modal Container - Positioned outside of scrollable elements -->
    <div id="modalContainer"></div>
    @include('petugas.borrowings.return-modal')

    <script>
        // Global handler untuk delete confirmation
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.classList.contains('confirm-delete')) {
                e.preventDefault();
                const message = form.getAttribute('data-confirm-message') || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.';

                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Hapus',
                    text: message,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    </script>
</body>
</html>
