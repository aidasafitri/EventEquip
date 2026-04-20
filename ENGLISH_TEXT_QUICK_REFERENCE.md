# QUICK REFERENCE: English Text Translation Summary
**Last Updated: 2026-04-14 | Analysis of 28 Blade.php Files**

---

## 🔴 MUST TRANSLATE (7 items total)

### 1. Logout Button
- **Where:** Top navigation bar (every page)
- **Current:** `Logout`
- **Change to:** `Keluar`
- **File:** `resources/views/layouts/app.blade.php` line 28

### 2-5. Edit Links (4 locations)
- **Where:** Action columns in admin data tables
- **Current:** `Edit`
- **Change to:** `Sunting`
- **Files:**
  1. `resources/views/admin/users/index.blade.php` line 53
  2. `resources/views/admin/equipments/index.blade.php` line 60
  3. `resources/views/admin/categories/index.blade.php` line 42
  4. `resources/views/admin/borrowings/index.blade.php` line 51

### 6. Edit User Title
- **Where:** User edit page heading
- **Current:** `Edit User`
- **Change to:** `Sunting Pengguna`
- **File:** `resources/views/admin/users/edit.blade.php` line 7

### 7. Admin Panel
- **Where:** Sidebar section header
- **Current:** `Admin Panel`
- **Change to:** `Panel Admin`
- **File:** `resources/views/layouts/sidebar.blade.php` line 5

---

## 🟢 NICE TO HAVE (2 items - Best Practice)

| Item | Current | Change to | File | Priority |
|------|---------|-----------|------|----------|
| HTML Language Attribute | `lang="en"` | `lang="id"` | `layouts/app.blade.php` line 2 | LOW - SEO/Accessibility |
| HTML Language Attribute | `lang="en"` | `lang="id"` | `welcome.blade.php` line 2 | LOW - SEO/Accessibility |

---

## 📊 STATISTICS

| Metric | Value |
|--------|-------|
| Total Blade Files | 28 |
| Files Analyzed | 28 (100%) |
| English Items Found | 7 |
| Already Translated | 95%+ |
| Files to Modify | 7 |
| Estimated Fix Time | 8 minutes |

---

## ✅ ALREADY TRANSLATED

The following are **NOT** English text (already in Indonesian or not user-visible):

- All page titles (Kelola User, Daftar Alat, etc.) ✓
- All form labels and buttons ✓
- All navigation menu items ✓
- All validation messages ✓
- All status indicators and badges ✓
- All modal titles and buttons ✓
- All table headers ✓
- All dashboard metrics ✓
- All sidebar menu items (except "Admin Panel") ✓

---

## 🎯 FILES TO MODIFY (Quick Checklist)

- [ ] `resources/views/layouts/app.blade.php` - Logout button
- [ ] `resources/views/layouts/sidebar.blade.php` - Admin Panel header
- [ ] `resources/views/admin/users/index.blade.php` - Edit link
- [ ] `resources/views/admin/equipments/index.blade.php` - Edit link
- [ ] `resources/views/admin/categories/index.blade.php` - Edit link
- [ ] `resources/views/admin/borrowings/index.blade.php` - Edit link
- [ ] `resources/views/admin/users/edit.blade.php` - Edit User title
- [ ] `resources/views/welcome.blade.php` - lang attribute (optional)

Total: 7-8 files (1 minute each = ~8 minutes total)

---

## Translation Recommendations

### Standard Terms to Use Consistently

| Action | English | Indonesian to Use | Example |
|--------|---------|------------------|---------|
| Edit/Modify | Edit | Sunting | "Sunting Pengguna" |
| Logout | Logout | Keluar | Navigation button |
| Create New | Add | Tambah | "+ Tambah User Baru" |
| Remove | Delete | Hapus | "Hapus" in tables |
| Store/Archive | Save | Simpan | "Simpan Alat" |
| Abort | Cancel | Batal | Form cancellation |
| Return/Go | Back | Kembali | "Kembali ke Dashboard" |
| OK/Yes | Confirm | Konfirmasi | Delete confirm |

---

## Language Setting

**Recommended:** Change HTML lang attribute from `"en"` to `"id"` for:
- Search engine optimization (SEO)
- Accessibility (screen readers)
- Browser language detection
- Mobile app language recognition

**Files:** 
- `layouts/app.blade.php`
- `welcome.blade.php`

