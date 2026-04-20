# Rencana Unit Testing - Sistem Manajemen Peminjaman Alat

**Sistem:** UKK-AIDA - Equipment Borrowing Management System  
**Tanggal:** April 2026  
**Scope:** Fitur-fitur utama sistem

---

## Daftar Tes Unit

| No. | ID Tes | Modul | Skenario Pengujian | Langkah-langkah | Data Uji (Jika Perlu) | Hasil yang Diharapkan | Hasil Aktual (Lulus/Gagal) |
|-----|--------|-------|-------------------|-----------------|----------------------|----------------------|---------------------------|
| 1 | AUTH001 | Autentikasi | Akses tanpa login | Logout → Akses /admin | - | Redirect ke /login | |
| 2 | AUTH002 | Autentikasi | Login gagal (password salah) | Login dengan password salah | admin / SalahPassword | Pesan error "Invalid credentials" | |
| 3 | AUTH003 | Autentikasi | Login sukses (Admin) | Login dengan kredensial admin valid | admin / admin123 | Redirect ke /admin | |
| 4 | AUTH004 | Autentikasi | Login sukses (Petugas) | Login dengan kredensial petugas valid | petugas1 / petugas123 | Redirect ke /petugas/borrowings | |
| 5 | AUTH005 | Autentikasi | Login sukses (Peminjam) | Login dengan kredensial user valid | user1 / user123 | Redirect ke /peminjam/equipments | |
| 6 | AUTH006 | Autentikasi | Logout sukses | Klik logout pada menu | - | Redirect ke /login | |
| 7 | AUTH007 | Autentikasi | Registrasi Peminjam | Isi form registrasi dan submit | nama / email@test.com / password | User terdaftar & bisa login | |
| 8 | AUTH008 | Autentikasi | Registrasi email duplikat | Isi form dengan email terdaftar | admin@example.com | Error "Email sudah terdaftar" | |
| 9 | USER001 | Kelola User | Lihat daftar user | Akses /admin/users | - | Tabel user tampil dengan data | |
| 10 | USER002 | Kelola User | Tambah user baru | Isi form dan submit | Budi / budi@example.com / password / phone | User tersimpan di database | |
| 11 | USER003 | Kelola User | Edit user | Ubah data user & submit | Ahmad / ahmad@example.com | Data user terupdate | |
| 12 | USER004 | Kelola User | Hapus user | Klik tombol hapus + konfirmasi | - | User terhapus dari database | |
| 13 | EQUIP001 | Kelola Alat | Lihat daftar alat | Akses /admin/equipments | - | Tabel alat tampil dengan data | |
| 14 | EQUIP002 | Kelola Alat | Tambah alat baru | Isi form alat & submit | Laptop Dell / Elektronik / 5 units | Alat tersimpan di database | |
| 15 | EQUIP003 | Kelola Alat | Upload foto alat | Upload file JPG/PNG max 2MB | file.jpg | Foto tersimpan & tampil | |
| 16 | EQUIP004 | Kelola Alat | Edit alat | Ubah nama/stok/kategori alat | Laptop ASUS / 10 units | Data alat terupdate | |
| 17 | EQUIP005 | Kelola Alat | Hapus alat | Klik tombol hapus + konfirmasi | - | Alat terhapus dari database | |
| 18 | EQUIP006 | Kelola Alat | Cek stok alat | Lihat informasi stok | - | Stok terlihat dengan jelas | |
| 19 | KAT001 | Kategori | Lihat kategori | Akses /admin/categories | - | Tabel kategori tampil | |
| 20 | KAT002 | Kategori | Tambah kategori | Isi form kategori & submit | Peralatan Renang / Deskripsi | Kategori tersimpan | |
| 21 | KAT003 | Kategori | Edit kategori | Ubah nama/deskripsi kategori | Perlengkapan Badminton | Kategori terupdate | |
| 22 | KAT004 | Kategori | Hapus kategori | Klik tombol hapus + konfirmasi | - | Kategori terhapus | |
| 23 | PNJM001 | Peminjaman | Lihat alat tersedia | Akses /peminjam/equipments | - | Daftar alat tersedia tampil | |
| 24 | PNJM002 | Peminjaman | Lihat detail alat | Klik detail alat | - | Detail alat & foto tampil | |
| 25 | PNJM003 | Peminjaman | Ajukan peminjaman | Isi form dan submit | Laptop ASUS / 1 / 7 hari | Status peminjaman = pending | |
| 26 | PNJM004 | Peminjaman | Cek limit peminjaman aktif | Coba ajuan baru saat sudah 2 aktif | - | Error "Maksimal 2 peminjaman aktif" | |
| 27 | PNJM005 | Peminjaman | Cek keterlambatan | Coba ajuan saat ada item terlambat | - | Error "Kembalikan item terlambat dulu" | |
| 28 | PNJM006 | Peminjaman | Lihat riwayat peminjaman | Akses /peminjam/my-borrowings | - | Daftar riwayat tampil | |
| 29 | PNJM007 | Peminjaman | Batalkan peminjaman pending | Klik batalkan pada pending item | - | Status = batalkan & konfirmasi | |
| 30 | PNJM008 | Peminjaman | Tidak bisa batalkan disetujui | Coba batalkan yang sudah disetujui | - | Tombol batalkan disabled/tidak ada | |
| 31 | PNGT001 | Petugas - Peminjaman | Lihat pending | Akses /petugas/borrowings | - | Daftar peminjaman pending tampil | |
| 32 | PNGT002 | Petugas - Peminjaman | Lihat semua peminjaman | Filter lihat semua peminjaman | - | Semua data peminjaman tampil | |
| 33 | PNGT003 | Petugas - Peminjaman | Setujui peminjaman | Klik approve + set durasi | 7 hari | Status = dipinjam | |
| 34 | PNGT004 | Petugas - Peminjaman | Tolak peminjaman | Klik reject + alasan | Stok habis | Status = ditolak & alasan tersimpan | |
| 35 | PNGT005 | Petugas - Pengembalian | Monitor pengembalian | Akses monitoring returns | - | Daftar item yang harus dikembalikan tampil | |
| 36 | PNGT006 | Petugas - Pengembalian | Verifikasi kondisi Baik | Pilih kondisi Baik & verifikasi | - | Status = dikembalikan | |
| 37 | PNGT007 | Petugas - Pengembalian | Verifikasi Rusak Ringan | Pilih rusak ringan & input denda | 50000 | Status = dikembalikan & denda tersimpan | |
| 38 | PNGT008 | Petugas - Pengembalian | Verifikasi Rusak Berat | Pilih rusak berat & input denda | 100000 | Status = dikembalikan & denda tersimpan | |
| 39 | PNGT009 | Petugas - Pengembalian | Verifikasi Hilang | Pilih hilang & input denda | 150000 | Status = dikembalikan & denda maksimal | |
| 40 | PNGT010 | Petugas - Pengembalian | Catat pembayaran denda | Klik bayar denda | - | Status denda = lunas | |
| 41 | ADMIN001 | Admin - Peminjaman | Lihat semua peminjaman | Akses /admin/borrowings | - | Tabel semua peminjaman tampil | |
| 42 | ADMIN002 | Admin - Peminjaman | Edit peminjaman | Ubah data peminjaman | - | Data terupdate | |
| 43 | ADMIN003 | Admin - Peminjaman | Hapus peminjaman | Klik hapus + konfirmasi | - | Peminjaman terhapus | |
| 44 | LOG001 | Activity Log | Lihat log aktivitas | Akses /admin/activity-logs | - | Daftar log aktivitas tampil | |
| 45 | LOG002 | Activity Log | Cek action terekam | Lakukan aksi & cek log | Create/Edit/Delete | Aksi terekam di log | |
| 46 | DASH001 | Dashboard | Dashboard Admin | Login admin & akses dashboard | - | Statistik & widget tampil | |
| 47 | DASH002 | Dashboard | Dashboard Petugas | Login petugas & akses dashboard | - | Menu petugas & statistik tampil | |
| 48 | DASH003 | Dashboard | Dashboard Peminjam | Login user & akses dashboard | - | Menu peminjam & statistik tampil | |

---

## Catatan Pengujian

### Metode Pengujian
- **Unit Testing:** Pengujian individual function dan method menggunakan PHPUnit
- **Feature Testing:** Pengujian fitur lengkap dengan HTTP request
- **Integration Testing:** Pengujian interaksi antar modul

### Validasi Data
- Email harus unique
- Password minimal 8 karakter
- Stok alat tidak boleh negatif
- Durasi peminjaman valid (1-30 hari)
- Denda otomatis dihitung berdasarkan keterlambatan

### Kriteria Kelulusan
Setiap test dianggap **LULUS** jika:
1. Output sesuai hasil yang diharapkan
2. Data tersimpan dengan benar di database
3. Status dan relasi data konsisten
4. Tidak ada error atau warning
5. Redirect & navigasi sesuai

