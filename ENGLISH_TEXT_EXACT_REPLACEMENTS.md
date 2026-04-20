# EXACT CODE REPLACEMENTS - Copy & Paste Ready

## File 1: `resources/views/layouts/app.blade.php` (Line 28)

### Find:
```blade
<button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
    Logout
</button>
```

### Replace with:
```blade
<button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
    Keluar
</button>
```

### Also Update (Line 2 - Optional, SEO benefit):
```blade
<!-- CURRENT: -->
<html lang="en">

<!-- REPLACE WITH: -->
<html lang="id">
```

---

## File 2: `resources/views/layouts/sidebar.blade.php` (Line 5)

### Find:
```blade
<h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Admin Panel</h3>
```

### Replace with:
```blade
<h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Panel Admin</h3>
```

---

## File 3: `resources/views/admin/users/index.blade.php` (Line 53)

### Find:
```blade
<a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
```

### Replace with:
```blade
<a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Sunting</a>
```

---

## File 4: `resources/views/admin/equipments/index.blade.php` (Line 60)

### Find:
```blade
<a href="{{ route('admin.equipments.edit', $equipment) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
```

### Replace with:
```blade
<a href="{{ route('admin.equipments.edit', $equipment) }}" class="text-blue-600 hover:text-blue-900">Sunting</a>
```

---

## File 5: `resources/views/admin/categories/index.blade.php` (Line 42)

### Find:
```blade
<a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
```

### Replace with:
```blade
<a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900">Sunting</a>
```

---

## File 6: `resources/views/admin/borrowings/index.blade.php` (Line 51)

### Find:
```blade
<a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
```

### Replace with:
```blade
<a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="text-blue-600 hover:text-blue-900">Sunting</a>
```

---

## File 7: `resources/views/admin/users/edit.blade.php` (Line 7)

### Find:
```blade
<h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
```

### Replace with:
```blade
<h1 class="text-3xl font-bold text-gray-900">Sunting Pengguna</h1>
```

---

## File 8 (Optional): `resources/views/welcome.blade.php` (Line 1-2)

### Find:
```blade
<html lang="en">
```

### Replace with:
```blade
<html lang="id">
```

---

## BATCH FIND & REPLACE INSTRUCTIONS

If using VS Code or similar editor with Find & Replace feature:

### Search 1: Replace "Logout"
- **Find:** `Logout` (exact case)
- **Replace with:** `Keluar`
- **File:** `layouts/app.blade.php`
- **Search scope:** Single file

### Search 2: Replace "Edit" in action columns
- **Find:** `>Edit</a>`
- **Replace with:** `>Sunting</a>`
- **Files:** (4 files in admin folder)
- **Caution:** Verify context before replacing to avoid matches in "Edit User" title

### Search 3: Replace "Edit User" title
- **Find:** `Edit User`
- **Replace with:** `Sunting Pengguna`
- **File:** `users/edit.blade.php`
- **Search scope:** Single file

### Search 4: Replace "Admin Panel"
- **Find:** `Admin Panel`
- **Replace with:** `Panel Admin`
- **File:** `sidebar.blade.php`
- **Search scope:** Single file

### Search 5: Replace lang attribute (HTML)
- **Find:** `lang="en"`
- **Replace with:** `lang="id"`
- **Files:** 2 files (app.blade.php, welcome.blade.php)
- **Importance:** Optional but recommended

---

## BEFORE & AFTER EXAMPLES

### Example 1: Navigation Button
**Before:**
```
┌─────────────────────┐
│ EventEquip | Logout │
└─────────────────────┘
```

**After:**
```
┌─────────────────────┐
│ EventEquip | Keluar │
└─────────────────────┘
```

### Example 2: Table Action
**Before:**
```
┌──────┬────────┬───────────┐
│ Nama │ Email  │ Tindakan  │
├──────┼────────┼───────────┤
│ John │ j@e.com│ Edit Hapus│
└──────┴────────┴───────────┘
```

**After:**
```
┌──────┬────────┬──────────────┐
│ Nama │ Email  │ Tindakan     │
├──────┼────────┼──────────────┤
│ John │ j@e.com│ Sunting Hapus│
└──────┴────────┴──────────────┘
```

### Example 3: Page Title
**Before:**
```
═════════════════════
    Edit User
═════════════════════
```

**After:**
```
═════════════════════
  Sunting Pengguna
═════════════════════
```

---

## TESTING CHECKLIST AFTER REPLACEMENT

- [ ] Navigate to user list page - verify "Sunting" link appears
- [ ] Navigate to equipment list page - verify "Sunting" link appears  
- [ ] Navigate to category list page - verify "Sunting" link appears
- [ ] Navigate to borrowing list page - verify "Sunting" link appears
- [ ] Click "Sunting" link on any page - should navigate correctly
- [ ] Click user edit page - verify title shows "Sunting Pengguna"
- [ ] Top navigation bar - verify "Keluar" button appears
- [ ] Click "Keluar" - should logout user successfully
- [ ] Check admin sidebar - verify "Panel Admin" text appears
- [ ] Test on mobile view - ensure text fits properly
- [ ] Test with all 3 user roles
- [ ] Run browser dev tools - check HTML lang="id" attribute (F12 → Elements)

---

## ROLLBACK INSTRUCTIONS

If you need to revert changes:

| File | Revert from | To |
|------|-------------|-----|
| `layouts/app.blade.php` | `Keluar` | `Logout` |
| `layouts/sidebar.blade.php` | `Panel Admin` | `Admin Panel` |
| `admin/users/index.blade.php` | `>Sunting</a>` | `>Edit</a>` |
| `admin/equipments/index.blade.php` | `>Sunting</a>` | `>Edit</a>` |
| `admin/categories/index.blade.php` | `>Sunting</a>` | `>Edit</a>` |
| `admin/borrowings/index.blade.php` | `>Sunting</a>` | `>Edit</a>` |
| `admin/users/edit.blade.php` | `Sunting Pengguna` | `Edit User` |
| `welcome.blade.php` | `lang="id"` | `lang="en"` |
| `layouts/app.blade.php` | `lang="id"` | `lang="en"` |

---

## NOTES FOR DEVELOPERS

1. **Case Sensitivity:** All replacements are case-sensitive
2. **Blade Syntax:** Don't modify `@`, `{{`, `}}`, `->` symbols
3. **HTML Attributes:** Don't modify `class`, `href`, or other attributes
4. **Route Names:** Don't modify `route()` function calls
5. **Database:** No database changes needed
6. **Cache:** Consider clearing Laravel cache after changes:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```
7. **Git:** Each replacement can be a separate commit for clarity

---

## RECOMMENDED COMMIT MESSAGE

```
localization: Translate remaining English UI text to Indonesian

- Change "Logout" → "Keluar" in navbar
- Change "Edit" → "Sunting" in 4 admin table pages  
- Change "Edit User" → "Sunting Pengguna" in user edit page
- Change "Admin Panel" → "Panel Admin" in sidebar
- Update HTML lang attribute from "en" to "id"

Fixes: #translation-issue
Complete translation coverage to Indonesian
```

