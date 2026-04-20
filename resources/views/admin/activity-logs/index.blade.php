@extends('layouts.app')

@section('title', 'Log Aktivitas - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Log Aktivitas Sistem</h1>
    <p class="text-slate-600 mt-2 text-lg">Pantau semua aktivitas pengguna di sistem</p>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Pengguna</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Aksi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Waktu</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($logs as $log)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-900">{{ $log->user->name ?? 'System' }}</p>
                            <p class="text-xs text-slate-600 font-medium">{{ $log->user->email ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-900 font-medium">{{ $log->action }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-600 font-medium">
                            Belum ada aktivitas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection
