@extends('layouts.app')

@section('title', 'Pantau Pengembalian - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Pantau Pengembalian Alat</h1>
    <p class="text-gray-600 mt-2">Pantau alat yang sedang dipinjam dan tanggal pengembaliannya</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($borrowings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $borrowing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $borrowing->equipment->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->equipment->code }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $borrowing->qty }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $borrowing->end_date->format('d/m/Y') }}</p>
                                @if ($borrowing->end_date < today())
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mt-1">Terlambat</span>
                                @elseif ($borrowing->end_date->diffInDays(today()) <= 1)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 mt-1">Segera</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Dipinjam
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" onclick="openReturnModal({{ $borrowing->id }}, {{ $borrowing->equipment->id }}, {{ json_encode(['id' => $borrowing->equipment->id, 'damagePrices' => $borrowing->equipment->damagePrices->map(fn($p) => ['damage_type' => $p->damage_type, 'price' => $p->price])->toArray()]) }})"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                    Dikembalikan
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            {{ $borrowings->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <div class="text-5xl mb-4">📦</div>
            <p class="text-gray-500 text-lg">Semua alat telah dikembalikan atau tidak ada yang dipinjam</p>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mt-2 inline-block">Kembali ke Dashboard</a>
        </div>
    @endif
</div>

<!-- Unpaid Fines Section -->
<div class="mt-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Pengembalian Belum Lunas</h2>
        <p class="text-gray-600 mt-2">Daftar peminjaman yang sudah dikembalikan namun dendanya belum dibayar</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if ($unPaidFines->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kerusakan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($unPaidFines as $borrowing)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">{{ $borrowing->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $borrowing->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">{{ $borrowing->equipment->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $borrowing->equipment->code }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        {{ $borrowing->borrowingReturn->getConditionLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-bold text-red-600">Rp {{ number_format($borrowing->borrowingReturn->damage_amount, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $borrowing->returned_at ? $borrowing->returned_at->format('d/m/Y') : '-' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Belum Lunas
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" onclick="confirmPayment({{ $borrowing->id }}, '{{ $borrowing->user->name }}', {{ $borrowing->borrowingReturn->damage_amount }})"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Lunas
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                {{ $unPaidFines->links('pagination::tailwind', ['paginator' => $unPaidFines, 'path' => route('petugas.borrowings.monitoring')]) }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="text-5xl mb-4">✅</div>
                <p class="text-gray-500 text-lg">Semua denda telah dibayar</p>
            </div>
        @endif
    </div>
</div>

<script>
function confirmPayment(borrowingId, userName, amount) {
    const formattedAmount = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);

    Swal.fire({
        title: 'Konfirmasi Pembayaran Denda',
        html: `<p class="text-lg">Peminjam: <strong>${userName}</strong></p>
               <p class="text-lg">Jumlah Denda: <strong class="text-red-600">${formattedAmount}</strong></p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Lunas',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            markFinePaid(borrowingId);
        }
    });
}

async function markFinePaid(borrowingId) {
    try {
        const response = await fetch(`/petugas/borrowings/${borrowingId}/fine/paid`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value ||
                               document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({}),
        });

        // ✅ CHECK RESPONSE STATUS FIRST
        if (!response.ok) {
            const contentType = response.headers.get('content-type');

            if (contentType && contentType.includes('application/json')) {
                // Response is JSON
                const data = await response.json();
                const errorMsg = data.message || data.errors || 'Terjadi kesalahan saat mencatat pembayaran';

                if (data.errors) {
                    // Validation errors
                    const errorList = Object.values(data.errors).flat().join(', ');
                    Swal.fire({
                        title: 'Validasi Gagal',
                        text: errorList,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error Server',
                    text: `HTTP ${response.status}: ${response.statusText}`,
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
            return;
        }

        // ✅ PARSE SUCCESSFUL RESPONSE
        const data = await response.json();

        if (data.success) {
            Swal.fire({
                title: 'Sukses!',
                text: 'Denda berhasil dilunas',
                icon: 'success',
                confirmButtonColor: '#10b981'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Terjadi kesalahan saat mencatat pembayaran',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    } catch (error) {
        console.error('Error details:', error);
        Swal.fire({
            title: 'Error',
            text: error.message,
            icon: 'error',
            confirmButtonColor: '#ef4444'
        });
    }
}
</script>

<!-- Include Return Modal -->
@include('petugas.borrowings.return-modal')

@endsection
