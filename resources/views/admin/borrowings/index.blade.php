@extends('layouts.app')

@section('title', 'Data Peminjaman - EventEquip')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900">Data Peminjaman</h1>
    <p class="text-slate-600 mt-2 text-lg">Kelola semua data peminjaman alat</p>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($borrowings as $borrowing)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-900">{{ $borrowing->user->name }}</p>
                            <p class="text-xs text-slate-600 font-medium">{{ $borrowing->user->email }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-900">{{ $borrowing->equipment->name }}</p>
                            <p class="text-xs text-slate-600 font-medium">{{ $borrowing->equipment->code }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm text-slate-900 font-medium">{{ $borrowing->qty }} {{ $borrowing->equipment->category->name ?? 'unit' }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                            {{ $borrowing->start_date->format('d/m/Y') }} - {{ $borrowing->end_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 text-xs font-bold rounded-full
                                @if ($borrowing->status === 'pending') bg-amber-100 text-amber-800
                                @elseif ($borrowing->status === 'approved') bg-blue-100 text-blue-800
                                @elseif ($borrowing->status === 'rejected') bg-rose-100 text-rose-800
                                @else bg-emerald-100 text-emerald-800 @endif">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold space-x-2">
                            <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="text-blue-600 hover:text-blue-800 transition">✎ Sunting</a>
                            <form method="POST" action="{{ route('admin.borrowings.destroy', $borrowing) }}" class="inline confirm-delete" data-confirm-message="Yakin ingin menghapus data peminjaman ini? Tindakan ini tidak dapat dibatalkan.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">🗑 Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-slate-600 font-medium">
                            Belum ada data peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6">
        {{ $borrowings->links() }}
    </div>
</div>
@endsection
