# 🖼️ FOTO ALAT FITUR - QUICK START GUIDE

## Apa yang Baru?

Sistem manajemen alat Anda sekarang dilengkapi dengan fitur **upload foto** yang membuat pengalaman pengguna lebih baik!

---

## ✨ Fitur Utama

### 1️⃣ Upload Foto saat Tambah Alat
```
Tambah Alat → Form → Klik Area Upload → Pilih File → Preview → Simpan
```

### 2️⃣ Ganti Foto saat Edit Alat
```
Edit Alat → Form → Upload Foto Baru → Old Photo Auto-Delete → Simpan
```

### 3️⃣ Lihat Foto di List (Desktop)
```
Grid 3 kolom → Foto Besar → Hover Zoom → Kondisi Badge → Action Buttons
```

### 4️⃣ Lihat Foto di List (Mobile)
```
Table Compact → Foto Thumbnail → Semua Info → Responsive Design
```

### 5️⃣ Peminjam Lihat Foto Alat
```
Grid Card → Foto Alat → Stok Bar → Kondisi → Ajukan Peminjaman
```

---

## 📸 Spesifikasi Foto

| Attribute | Value |
|-----------|-------|
| Format | JPG, PNG, GIF |
| Max Size | 2 MB |
| Recommended | 800x600px |
| Compression | Native browser |
| Storage | `/storage/equipments/` |
| Default | Placeholder jika no photo |

---

## 🎯 User Flow

### Admin - Tambah Alat dengan Foto

```
1. Buka Menu Admin → Kelola Alat
2. Klik Tombol "+ Tambah Alat"
3. Isi form:
   - Kategori ✓
   - Nama Alat ✓
   - Kode Alat ✓
   - Qty Total ✓
   - Kondisi ✓
   - Deskripsi (optional)
   - FOTO (optional) ← NEW!
4. Pada foto:
   - Klik area upload / drag & drop
   - Atau browse file dari komputer
   - Lihat preview sebelum submit
5. Klik "Simpan Alat"
6. Foto otomatis tersimpan dan ditampilkan
```

### Admin - Edit Alat & Ganti Foto

```
1. Di list alat, klik "Sunting"
2. Form edit terbuka dengan:
   - Foto saat ini ditampilkan ✓
   - Info: nama file, upload date
3. Untuk ganti foto:
   - Klik area upload
   - Pilih foto baru
   - Lihat preview
4. Klik "Simpan Perubahan"
5. Foto lama otomatis terhapus ✓
6. Foto baru ditampilkan
```

### Admin - View Daftar Alat

**Desktop/Laptop:**
```
Grid View 3 Kolom
├── Card 1: Foto Besar (hover zoom)
│   ├── Kode Alat
│   ├── Nama Alat
│   ├── Kategori
│   ├── Stok Progress Bar
│   ├── Deskripsi
│   └── Tombol Sunting/Hapus
├── Card 2: ...
└── Card 3: ...
```

**Tablet/Mobile:**
```
Table View Compact
├── Foto (thumbnail)
├── Nama + Kode (text)
├── Stok (number)
└── Aksi (Sunting/Hapus)
```

### Peminjam - Lihat Foto Alat

```
Grid 1-3 Kolom (responsive)
├── Foto Alat
│   └── Badge Kondisi
│   └── Overlay "Stok Habis" jika unavailable
├── Info:
│   ├── Kode
│   ├── Kategori
│   ├── Stok Bar
│   ├── Kondisi
│   └── Deskripsi
└── Tombol "Ajukan Peminjaman" atau "Stok Habis"
```

---

## 🚀 Deployment Commands

Jika Anda baru pertama kali setup atau restore backup:

```bash
# 1. Jalankan migration
php artisan migrate

# 2. Setup storage link
php artisan storage:link

# 3. Create folder untuk foto
mkdir -p storage/app/public/equipments
chmod 755 storage/app/public/equipments
```

**Status setelah implementasi ini:** ✅ Semua sudah dijalankan

---

## 🔍 Cara Cek Foto Tersimpan

### Via File Manager
```
Project Folder
└── storage/app/public/equipments/
    ├── uuid-xxxx-1.jpg
    ├── uuid-xxxx-2.png
    └── uuid-xxxx-3.gif
```

### Via Web Browser
```
http://localhost:8000/storage/equipments/uuid-xxxx.jpg
```

### Di Database
```sql
SELECT id, name, code, photo FROM equipments;
-- photo column berisi: uuid-xxxx.jpg
```

---

## ⚡ Performance Tips

1. **Resize Image sebelum upload** (opsional)
   - Idealnya 800x600 atau lebih kecil
   - Format JPG untuk file lebih kecil

2. **Monitor Storage**
   - Check folder: `storage/app/public/equipments/`
   - Hapus foto lama jika perlu space

3. **Clear Cache** (jika cache enabled)
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

---

## 🐛 Troubleshooting

### Foto tidak tampil
**Solusi:**
```bash
# Re-setup storage link
php artisan storage:link

# Check folder permissions
ls -la storage/app/public/equipments/
chmod 755 storage/app/public/equipments/
```

### Upload gagal
**Cek:**
- File size < 2MB
- Format: JPG, PNG, GIF
- Folder permissions OK
- Disk space cukup

### Placeholder tidak tampil
**Solusi:**
```bash
# Check if placeholder exists
ls public/images/default-equipment.png

# It should be there
```

---

## 📱 Responsive Behavior

| Device | View | Columns |
|--------|------|---------|
| Desktop (1200px+) | Grid | 3 |
| Tablet (768-1200px) | Grid/Table | 2 atau table |
| Mobile (< 768px) | Table | 1 (compact) |

---

## 🔐 Security Features

✅ **Implemented:**
- File type validation (image only)
- File size limit (2MB)
- Unique filename (UUID) - prevent injection
- Stored outside public folder
- Delete old file safely
- Error handling

---

## 💡 Tips & Tricks

### 1. Drag & Drop Upload
```
Just drag your image file to the upload area!
```

### 2. Preview Before Submit
```
See your photo before saving
Click area to change / preview updates
```

### 3. Auto Old Photo Delete
```
When you upload new photo, old one is automatically deleted
No manual cleanup needed!
```

### 4. Fallback Placeholder
```
If equipment has no photo, a nice placeholder image shown
No broken images or empty spaces
```

---

## 📊 Database Info

### Kolom Baru
```sql
-- Added to equipments table
ALTER TABLE equipments ADD COLUMN photo VARCHAR(255) NULL;
```

### Migration File
```
database/migrations/2026_04_20_000001_add_photo_to_equipments_table.php
```

### Status
✅ Migration sudah dijalankan
✅ Kolom sudah ada di database

---

## 📚 File References

### Core Files
- Model: `app/Models/Equipment.php`
- Controller: `app/Http/Controllers/Admin/EquipmentController.php`
- Migration: `database/migrations/2026_04_20_000001_...`

### Views
- Admin Create: `resources/views/admin/equipments/create.blade.php`
- Admin Edit: `resources/views/admin/equipments/edit.blade.php`
- Admin List: `resources/views/admin/equipments/index.blade.php`
- User List: `resources/views/peminjam/equipments/index.blade.php`

### Documentation
- Detailed Guide: `EQUIPMENT_PHOTO_FEATURE.md`
- Implementation Summary: `EQUIPMENT_PHOTO_IMPLEMENTATION_SUMMARY.md`
- This File: `EQUIPMENT_PHOTO_QUICK_START.md`

---

## 🎉 What's Next?

You can now:
1. ✅ Upload photos for new equipment
2. ✅ Update photos for existing equipment
3. ✅ View beautiful photo grids
4. ✅ Have proper mobile experience
5. ✅ Provide better user experience

---

## 📞 Need Help?

Check these files:
1. `EQUIPMENT_PHOTO_FEATURE.md` - Detailed technical guide
2. `EQUIPMENT_PHOTO_IMPLEMENTATION_SUMMARY.md` - Complete summary
3. `UNIT_TESTING_PLAN.md` - Test cases
4. Laravel Docs - https://laravel.com/docs

---

**Version:** 1.0  
**Date:** April 20, 2026  
**Status:** ✅ Production Ready  

Enjoy your new photo feature! 📸✨

