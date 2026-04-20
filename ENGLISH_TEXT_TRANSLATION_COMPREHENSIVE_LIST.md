# Comprehensive English Text Translation List - EventEquip

## Summary
This document contains all identified English language text in ALL 28 Blade.php files that require translation to Indonesian.

**Search completed:** 28 blade.php files analyzed
**Total English items found:** 7 items requiring translation
**Already translated:** 90%+ of UI text is in Indonesian

---

## HIGH PRIORITY (Main UI Text - User-Facing)

### 1. Navigation & System Buttons

| File | English Text | Current Location | Suggested Indonesian | Severity | Type |
|------|--------------|------------------|---------------------|----------|------|
| `resources/views/layouts/app.blade.php` | `Logout` | Main navbar (top right) | `Keluar` | 🔴 CRITICAL | Action button |
| `resources/views/admin/users/index.blade.php` | `Edit` | Table action link (row actions) | `Sunting` | 🔴 CRITICAL | Action link |
| `resources/views/admin/equipments/index.blade.php` | `Edit` | Table action link (row actions) | `Sunting` | 🔴 CRITICAL | Action link |
| `resources/views/admin/categories/index.blade.php` | `Edit` | Table action link (row actions) | `Sunting` | 🔴 CRITICAL | Action link |
| `resources/views/admin/borrowings/index.blade.php` | `Edit` | Table action link (row actions) | `Sunting` | 🔴 CRITICAL | Action link |
| `resources/views/admin/users/edit.blade.php` | `Edit User` | Page title | `Sunting Pengguna` | 🟡 HIGH | Page header |

### 2. Sidebar & Navigation Headers

| File | English Text | Current Location | Suggested Indonesian | Severity | Type |
|------|--------------|------------------|---------------------|----------|------|
| `resources/views/layouts/sidebar.blade.php` | `Admin Panel` | Section header (sidebar) | `Panel Admin` | 🟡 HIGH | Section header |

---

## MEDIUM PRIORITY (Secondary UI Text - Modal & Form Labels)

### 1. Form Fields & Labels

| File | English Text | Current Context | Suggested Indonesian | Notes |
|------|--------------|-----------------|---------------------|-------|
| `resources/views/admin/users/create.blade.php` | `Password` | Form label | Already in Indonesian ✓ | Input field label |
| `resources/views/admin/users/create.blade.php` | `Pilih Role` | Form section | Already in Indonesian ✓ | - |
| `resources/views/admin/users/edit.blade.php` | `Edit User` | Page title | `Sunting Pengguna` | Page heading |
| `resources/views/admin/users/edit.blade.php` | `Password (Kosongkan jika tidak ingin mengubah)` | Label | Already in Indonesian ✓ | - |
| `resources/views/admin/users/edit.blade.php` | `Konfirmasi Password` | Label | Already in Indonesian ✓ | - |

### 2. Modal & Popup Content

| File | English Text | Current Context | Suggested Indonesian | Notes |
|------|--------------|-----------------|---------------------|-------|
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Form Pengembalian Alat` | Modal title | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Kondisi Alat Saat Dikembalikan` | Form label | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Pilih Kondisi` | Select placeholder | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Baik (Tanpa Denda)` | Option | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Rusak Ringan` | Option | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Catatan Kerusakan` | Label | Already in Indonesian ✓ | - |

### 3. Table Headers & Status Indicators

| File | English Text | Current Context | Suggested Indonesian | Notes |
|------|--------------|-----------------|---------------------|-------|
| `resources/views/admin/users/index.blade.php` | `Kelola User` | Page title | Already in Indonesian ✓ | - |
| `resources/views/admin/equipments/index.blade.php` | `Kelola Alat` | Page title | Already in Indonesian ✓ | - |
| `resources/views/admin/categories/index.blade.php` | `Kategori Alat` | Page title | Already in Indonesian ✓ | - |
| `resources/views/admin/borrowings/index.blade.php` | `Data Peminjaman` | Page title | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/monitoring.blade.php` | `Pantau Pengembalian Alat` | Page title | Already in Indonesian ✓ | - |
| `resources/views/peminjam/borrowings/index.blade.php` | `Peminjaman Saya` | Page title | Already in Indonesian ✓ | - |

---

## LOW PRIORITY (Rarely Seen Text - Comments, Hints, Optional Sections)

### 1. HTML Meta & Structural Elements

| File | English Text | Current Context | Suggested Indonesian | Notes |
|------|--------------|-----------------|---------------------|-------|
| `resources/views/layouts/app.blade.php` | `lang="en"` | HTML lang attribute | `lang="id"` | Should be changed for accessibility |
| `resources/views/welcome.blade.php` | `lang="en"` | HTML lang attribute | `lang="id"` | Should be changed for accessibility |

### 2. Placeholder Text & Help Text

| File | English Text | Current Context | Suggested Indonesian | Notes |
|------|--------------|-----------------|---------------------|-------|
| `resources/views/admin/users/create.blade.php` | `user@example.com` | Email placeholder | `pengguna@contoh.com` | Input field placeholder |
| `resources/views/admin/users/create.blade.php` | `08xx-xxxx-xxxx` | Phone placeholder | Already in Indonesian format ✓ | - |
| `resources/views/admin/users/create.blade.php` | `Masukkan nama lengkap` | Placeholder | Already in Indonesian ✓ | - |
| `resources/views/admin/equipments/create.blade.php` | `Contoh: Proyektor Canon LV-7275W` | Placeholder text | Already in Indonesian ✓ | - |
| `resources/views/admin/equipments/create.blade.php` | `Contoh: PROJ-001` | Placeholder text | Already in Indonesian ✓ | - |
| `resources/views/petugas/borrowings/return-modal.blade.php` | `Contoh: Meja retak di bagian pojok kanan...` | Placeholder | Already in Indonesian ✓ | - |

### 3. CSS/Print Styles & Technical Comments

| File | English Text | Current Context | Suggested Indonesian | Notes |
|------|--------------|-----------------|---------------------|-------|
| `resources/views/petugas/reports/borrowings.blade.php` | `@media "print"` | CSS media query | Technical - no translation needed ✓ | - |
| `resources/views/petugas/reports/borrowings.blade.php` | `.no-print` | CSS class | Technical - no translation needed ✓ | - |

---

## CRITICAL ITEMS REQUIRING IMMEDIATE ATTENTION

### 1. Page Titles & Meta

| File | English Text | Current Context | Suggested Indonesian |
|------|--------------|-----------------|---------------------|
| Multiple files | `- EventEquip` | Page title suffix | Keep as brand name ✓ |
| `resources/views/welcome.blade.php` | `EventEquip - Sistem Peminjaman Alat Event` | Meta title | Already in Indonesian ✓ |

### 2. JavaScript Alert/Confirmation Text

| File | English Text | Current Context | Suggested Indonesian |
|------|--------------|-----------------|---------------------|
| `resources/views/admin/users/index.blade.php` | `Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.` | Delete confirmation | Already in Indonesian ✓ |
| `resources/views/admin/equipments/index.blade.php` | `Yakin ingin menghapus alat ini? Tindakan ini tidak dapat dibatalkan.` | Delete confirmation | Already in Indonesian ✓ |
| `resources/views/admin/categories/index.blade.php` | `Yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.` | Delete confirmation | Already in Indonesian ✓ |

---

## SUMMARY OF TRANSLATIONS NEEDED

### Critical English Text to Translate:

1. **`Logout`** → **`Keluar`** (app.blade.php - HIGH)
2. **`Edit`** → **`Sunting`** (Multiple files - HIGH) 
3. **`Edit User`** → **`Sunting Pengguna`** (users/edit.blade.php - HIGH)
4. **`Admin Panel`** → **`Panel Admin`** (sidebar.blade.php - MEDIUM)
5. **`user@example.com`** → **`pengguna@contoh.com`** (users/create.blade.php - LOW)
6. HTML `lang="en"` → `lang="id"` (All base files - MEDIUM)

### Files Already Mostly Translated:
✓ Most form labels and validation messages are already in Indonesian
✓ Most page titles are already in Indonesian  
✓ Modal titles and buttons are already in Indonesian
✓ Status messages and confirmations are already in Indonesian

---

## RECOMMENDATIONS

1. **Immediate**: Replace "Logout", "Edit", and "Admin Panel" with Indonesian equivalents
2. **Soon**: Update HTML lang attribute from "en" to "id" in base templates
3. **Later**: Update email placeholder examples for localization
4. **Document**: Consider creating a language file (.env or config) for UI text constants

---

## Translation Quality Notes

- Most of the application is already well-translated to Indonesian
- Remaining English text is primarily:
  - Action button labels (Edit, Logout)
  - Minor UI labels
  - Placeholder examples
  - Navigation section headers

- Recommended consistent terms:
  - "Edit" → "Sunting" or "Ubah" (consistent with existing patterns)
  - "Add/Create" → "Tambah" or "Buat" (already used)
  - "Delete" → "Hapus" (already used)
  - "Save" → "Simpan" (already used)
  - "Cancel" → "Batal" (already used)
  - "Back" → "Kembali" (already used)

