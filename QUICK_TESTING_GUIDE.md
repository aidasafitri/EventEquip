# 🧪 STEP-BY-STEP TESTING GUIDE - QUICK START

## QUICK START (5 MENIT)

### **Step 1: Buka halaman monitoring**
```
Go to: http://ukk-aida.test/petugas/borrowings/monitoring
Login jika diperlukan
```

### **Step 2: Click button "Dikembalikan"**
```
Cari tabel "Pantau Pengembalian Alat"
Pilih salah satu baris
Klik button hijau "Dikembalikan"
```

### **Expected:** Modal terbuka floating di tengah layar

---

### **Step 3: Pilih kondisi "Baik"**
```
Dropdown: "Kondisi Alat Saat Dikembalikan"
Pilih: "Baik (Tanpa Denda)"
```

### **Step 4: Click "Simpan Pengembalian"**
```
Klik button hijau di bawah modal
```

### **Expected:**
```
✅ Modal tetap terbuka sebentar
✅ Alert popup: "✓ Pengembalian berhasil dicatat!"
✅ Halaman auto-reload setelah 1.5 detik
❌ BUKAN: "Unexpected token '<'" error
```

---

### **Step 5: Verify database (Optional)**
```bash
# Di terminal MySQL/Workbench:
SELECT * FROM borrowing_returns
ORDER BY created_at DESC
LIMIT 1;

# Should show:
# - condition: 'baik'
# - damage_amount: 0
# - payment_status: 'paid'
```

---

## ✅ IF TEST PASSES

**Congratulations! ✨ Error sudah fixed.**

Database:
- ✅ Data tersimpan correctly
- ✅ Borrowing status updated
- ✅ Equipment qty increased

---

## ❌ IF TEST FAILS

### **Error 1: Still get "Unexpected token '<'" error**

**Step A:** Open browser DevTools (F12)

**Step B:** Go to Network tab
- Refresh halaman
- Click "Dikembalikan" again
- Look at POST request to `/petugas/borrowings/X/returned`

**Step C:** Click the request, then "Response" tab
```
Should show:
{
  "success": true,
  "message": "Pengembalian berhasil dicatat",
  ...
}

NOT should show:
<!DOCTYPE html>
<html>
...
```

**If still shows HTML:**
1. Check `storage/logs/laravel.log` for errors
2. Verify file modifications were applied
3. Clear browser cache (Ctrl+Shift+Delete)
4. Run: `php artisan config:cache`

---

### **Error 2: Modal not showing**

**Check:**
```
1. Browser console (F12 → Console) - any JS errors?
2. Check if layout.blade.php has @include modal
3. Check if return-modal.blade.php exists
4. Try refresh page (Ctrl+F5)
```

---

### **Error 3: Form validation error**

**Symptoms:** Alert says "Validasi gagal: condition field required"

**Expected:** This means server validation working (good!)

**Action:** Just select condition before submit

---

### **Error 4: Database shows no changes**

**Check:**
```sql
SELECT * FROM borrowing_returns WHERE borrowing_id = [ID];
-- Should exist after successful submit

SELECT status FROM borrowings WHERE id = [ID];
-- Should be 'returned'
```

If no data:
- Check if form actually submitted (check Network tab)
- Check if response was success
- Check Laravel logs for database errors

---

## 🔧 MANUAL VERIFICATION (Jika masih ragu)

### **Check 1: Verify Files Modified**

```bash
# Check if changes exist in controller
grep -n "try {" app/Http/Controllers/Petugas/BorrowingController.php
# Should show results around line 72

# Check if changes in JS
grep -n "response.ok" resources/views/petugas/borrowings/return-modal.blade.php
# Should show results around line 122
```

---

### **Check 2: Verify Exception Handling**

Open `app/Http/Controllers/Petugas/BorrowingController.php`

Find `public function markReturned`:
```php
// Should see:
try {
    $borrowing = Borrowing::findOrFail($id);

    if ($borrowing->status !== 'approved') {
        if ($request->expectsJson()) {
            return response()->json([...], 400);
```

If not there → File wasn't saved properly

---

### **Check 3: Test dengan curl**

```bash
# Get CSRF token first
curl -s http://ukk-aida.test/petugas/borrowings/monitoring | grep "_token" | head -1
# Copy token value

# Test submission
curl -X POST \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: [PASTE_TOKEN_HERE]" \
  -d '{"condition":"baik","notes":""}' \
  -b "LARAVEL_SESSION=[YOUR_SESSION]" \
  http://ukk-aida.test/petugas/borrowings/1/returned

# Should return JSON like:
# {"success":true,"message":"Pengembalian berhasil dicatat",...}
# NOT HTML
```

---

## 📋 FULL TESTING CHECKLIST

```
□ Test 1: Valid submission (baik)
  - Open modal
  - Select "Baik"
  - Click submit
  - Expected: success alert, reload
  - Check DB: damage_amount = 0

□ Test 2: Valid submission (rusak_sedang)
  - Open modal
  - Select "Rusak Sedang"
  - Click submit
  - Expected: success alert with damage amount
  - Check DB: damage_amount != 0, payment_status = 'unpaid'

□ Test 3: No condition selected
  - Open modal
  - DON'T select anything
  - Click submit
  - Expected: error message "Pilih kondisi"
  - Modal stays open

□ Test 4: Network check
  - F12 → Network tab
  - Submit form
  - Check POST response
  - Expected: application/json, not HTML

□ Test 5: Browser console
  - F12 → Console
  - Submit form
  - Expected: no red errors about JSON parsing
  - No "Unexpected token '<'" errors

□ Test 6: Multiple submissions
  - Open modal, submit, close
  - Reload page
  - Open modal again on different item
  - Submit
  - Expected: both successful, no interference
```

---

## 🎯 SUCCESS CRITERIA

**Test PASSED jika:**

✅ Modal appear sebagai overlay
✅ Submit form work tanpa "Unexpected token '<'" error
✅ Success alert muncul
✅ Page reload
✅ Data tersimpan di database
✅ Borrowing status berubah ke 'returned'
✅ Equipment qty_available meningkat

**Test FAILED jika:**

❌ Still getting HTML parsing error
❌ Modal tidak appear atau tidak floating
❌ Form data tidak tersimpan
❌ Database data tidak berubah

---

## 🆘 HELP SECTION

### **Jika perlu lihat detail lengkap:**

Buka file dokumentasi:

1. **Error Analysis:** `ERROR_FIX_DOCUMENTATION.md`
2. **Quick Summary:** `QUICK_FIX_SUMMARY.md`
3. **Database Safety:** `DATABASE_INTEGRITY_CHECK.md`

---

### **Jika masih error, berikan info ini:**

```
1. Screenshot dari error
2. Network tab response dari failed request
3. Browser console errors (F12 → Console)
4. Laravel log last 50 lines:
   tail -50 storage/logs/laravel.log
5. File modified confirmation:
   grep "catch (\\\Illuminate" app/Http/Controllers/Petugas/BorrowingController.php
```

---

**Expected Result:** ✅ ALL TESTS PASS!

**Time Estimate:** 5-10 minutes untuk full testing

**Status:** Ready for deployment setelah test pass
