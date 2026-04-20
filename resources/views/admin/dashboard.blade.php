@extends('layouts.app')

@section('title', 'Dashboard Admin - EventEquip')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600 mt-2">Selamat datang di dashboard admin EventEquip.</p>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// CREATE (Tambah Data)
function showCreateValidationError() {
    Swal.fire({
        icon: 'warning',
        title: 'Mohon lengkapi semua data',
        text: 'Data belum lengkap. Silakan periksa kembali input Anda.'
    });
}
function showCreateFormatError() {
    Swal.fire({
        icon: 'error',
        title: 'Format data tidak valid',
        text: 'Format data tidak valid. Periksa kembali isian Anda.'
    });
}
function showCreateConfirm(callback) {
    Swal.fire({
        icon: 'question',
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyimpan data ini?',
        showCancelButton: true,
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') callback();
    });
}
function showCreateSuccess() {
    Swal.fire({
        icon: 'success',
        title: '✅ Data berhasil ditambahkan.'
    });
}

// READ (Tampilkan Data)
function showReadEmpty() {
    Swal.fire({
        icon: 'info',
        title: 'Tidak ada data yang tersedia.'
    });
}
function showReadFail() {
    Swal.fire({
        icon: 'error',
        title: 'Gagal memuat data',
        text: 'Gagal memuat data. Silakan coba lagi.'
    });
}

// UPDATE (Edit Data)
function showUpdateValidation() {
    Swal.fire({
        icon: 'warning',
        title: 'Pastikan semua data sudah benar sebelum diperbarui.'
    });
}
function showUpdateConfirm(callback) {
    Swal.fire({
        icon: 'question',
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin memperbarui data ini?',
        showCancelButton: true,
        confirmButtonText: 'Ya, perbarui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') callback();
    });
}
function showUpdateSuccess() {
    Swal.fire({
        icon: 'success',
        title: '✅ Data berhasil diperbarui.'
    });
}
function showUpdateFail() {
    Swal.fire({
        icon: 'error',
        title: 'Gagal memperbarui data',
        text: 'Gagal memperbarui data. Silakan coba lagi.'
    });
}

// DELETE (Hapus Data)
function showDeleteConfirm(callback) {
    Swal.fire({
        icon: 'warning',
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') callback();
    });
}
function showDeleteSuccess() {
    Swal.fire({
        icon: 'success',
        title: '✅ Data berhasil dihapus.'
    });
}
function showDeleteFail() {
    Swal.fire({
        icon: 'error',
        title: 'Gagal menghapus data',
        text: 'Gagal menghapus data. Silakan coba lagi.'
    });
}
</script>
@endpush
