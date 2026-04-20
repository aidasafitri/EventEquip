@extends('layouts.app')

@section('title', 'Kelola User - EventEquip')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-4xl font-bold text-slate-900">Kelola User</h1>
        <p class="text-slate-600 mt-2 text-lg">Manajemen pengguna sistem EventEquip</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-md hover:shadow-lg">
        + Tambah User Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm text-slate-600 font-medium">{{ $user->email }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm text-slate-600 font-medium">{{ $user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-2 flex-wrap">
                                @foreach ($user->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                        @if ($role->name === 'admin') bg-red-100 text-red-700
                                        @elseif ($role->name === 'petugas') bg-blue-100 text-blue-700
                                        @else bg-emerald-100 text-emerald-700 @endif">
                                        {{ $role->label }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 transition">✎ Sunting</a>
                            @if ($user->id !== Auth::id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline confirm-delete" data-confirm-message="Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">🗑 Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-slate-600 font-medium">
                            Belum ada user. <a href="{{ route('admin.users.create') }}" class="text-blue-600 hover:underline font-semibold">Buat user baru</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
