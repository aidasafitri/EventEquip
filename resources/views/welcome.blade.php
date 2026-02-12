<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventEquip - Sistem Peminjaman Alat Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg">
                        <span class="text-2xl font-bold">EventEquip</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Logout</button>
                        </form>
                    @else
                       
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4">EventEquip</h1>
                <p class="text-xl md:text-2xl text-gray-700 mb-8">Sistem Manajemen Peminjaman Alat Event</p>
                <p class="text-gray-600 text-lg mb-8">Kelola peminjaman alat event dengan mudah, cepat, dan efisien</p>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Mulai Login
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Admin</h3>
                    <p class="text-gray-600">Kelola pengguna, alat, kategori, dan pantau semua aktivitas sistem</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Petugas</h3>
                    <p class="text-gray-600">Setujui peminjaman, pantau pengembalian, dan buat laporan</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-909 mb-2">Peminjam</h3>
                    <p class="text-gray-600">Lihat alat tersedia, ajukan peminjaman, dan kembalikan alat</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Fitur Utama</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Manajemen Inventori</h4>
                            <p class="text-gray-600">Kelola inventori alat dengan mudah, catat stok, dan monitor kondisi</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Persetujuan Otomatis</h4>
                            <p class="text-gray-600">Sistem persetujuan peminjaman yang terstruktur dan transparan</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Laporan Terperinci</h4>
                            <p class="text-gray-600">Buat laporan peminjaman dengan detail dan mudah dicetak</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Log Aktivitas</h4>
                            <p class="text-gray-600">Pantau semua aktivitas sistem untuk keamanan dan transparansi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>
