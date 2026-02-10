<aside class="fixed left-0 top-16 w-64 h-full bg-gray-900 text-white overflow-y-auto">
    <div class="p-4">
        @if (Auth::user()->isAdmin())
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Admin Panel</h3>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">👥</span>
                        <span>Kelola User</span>
                    </a>
                    <a href="{{ route('admin.equipments.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.equipments.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">🛠️</span>
                        <span>Kelola Alat</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📁</span>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ route('admin.borrowings.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.borrowings.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📋</span>
                        <span>Peminjaman</span>
                    </a>
                    <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📝</span>
                        <span>Log Aktivitas</span>
                    </a>
                </nav>
            </div>
        @elseif (Auth::user()->isPetugas())
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Petugas</h3>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('petugas.borrowings.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('petugas.borrowings.index') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">✅</span>
                        <span>Setujui Peminjaman</span>
                    </a>
                    <a href="{{ route('petugas.borrowings.monitoring') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('petugas.borrowings.monitoring') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">👁️</span>
                        <span>Pantau Pengembalian</span>
                    </a>
                    <a href="{{ route('petugas.reports.borrowings') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('petugas.reports.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">🖨️</span>
                        <span>Cetak Laporan</span>
                    </a>
                </nav>
            </div>
        @elseif (Auth::user()->isPeminjam())
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Peminjam</h3>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('peminjam.equipments.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('peminjam.equipments.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">🔍</span>
                        <span>Lihat Daftar Alat</span>
                    </a>
                    <a href="{{ route('peminjam.borrowings.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('peminjam.borrowings.*') ? 'bg-blue-600' : '' }}">
                        <span class="text-lg mr-3">📦</span>
                        <span>Peminjaman Saya</span>
                    </a>
                </nav>
            </div>
        @endif
    </div>
</aside>

<div class="ml-64">
    <!-- Content takes full width with sidebar offset -->
</div>
