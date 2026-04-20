# 🔍 DATABASE VERIFICATION & DATA INTEGRITY CHECK

## Jika User Sudah Submit Sebelum Fix

Penjelasan: Bagaimana memverifikasi apakah ada data partial yang tersimpan di database

---

## 📋 CHECKING BORROWING_RETURNS TABLE

### **SQL Query untuk Check:**

```sql
-- 1. Check semua borrowing_returns records
SELECT
    br.id,
    br.borrowing_id,
    br.condition,
    br.damage_amount,
    br.payment_status,
    b.status as borrowing_status,
    b.user_id,
    b.equipment_id,
    br.created_at
FROM borrowing_returns br
LEFT JOIN borrowings b ON br.borrowing_id = b.id
ORDER BY br.created_at DESC;

-- 2. Check borrowings dengan status 'returned'
SELECT
    id,
    user_id,
    equipment_id,
    status,
    returned_at,
    created_at
FROM borrowings
WHERE status = 'returned'
ORDER BY returned_at DESC;

-- 3. Check for orphaned borrowing_returns (no corresponding borrowing)
SELECT
    br.id,
    br.borrowing_id,
    br.condition,
    b.id as borrowing_exists
FROM borrowing_returns br
LEFT JOIN borrowings b ON br.borrowing_id = b.id
WHERE b.id IS NULL;  -- This should be EMPTY

-- 4. Check equipment qty_available consistency
SELECT
    e.id,
    e.name,
    e.qty_total,
    e.qty_available,
    COUNT(DISTINCT CASE WHEN b.status = 'approved' THEN b.id END) as approved_count
FROM equipments e
LEFT JOIN borrowings b ON e.id = b.equipment_id
GROUP BY e.id, e.name
ORDER BY e.id;
```

---

## ✅ EXPECTED RESULTS AFTER FIX

### **Scenario 1: Successful Submission**

```sql
-- borrowing_returns should have:
SELECT * FROM borrowing_returns WHERE id = X;
-- Results MUST have:
-- - borrowing_id: valid ID
-- - condition: one of (baik, rusak_ringan, rusak_sedang, rusak_berat)
-- - damage_amount: >= 0
-- - payment_status: 'paid' or 'unpaid'
-- - notes: null or text

-- borrowings should have:
SELECT * FROM borrowings WHERE id = X;
-- Results MUST have:
-- - status: 'returned' (changed from 'approved')
-- - returned_at: NOT NULL (set to now())
-- - qty_available of equipment should be INCREMENTED

-- equipments should have:
SELECT qty_available FROM equipments WHERE id = X;
-- Results MUST show: increased quantity
```

### **Scenario 2: Failed Submission (Before Fix)**

If user got error while submitting, they might see:

```sql
-- Check if orphaned data exists:
SELECT * FROM borrowing_returns WHERE borrowing_id NOT IN (SELECT id FROM borrowings);

-- RISK: Orphaned borrowing_returns (borrowing tidak ada)
-- If found, need cleanup (lihat recovery procedure di bawah)
```

---

## 🛠️ RECOVERY PROCEDURES

### **Jika Ada Orphaned borrowing_returns:**

```sql
-- 1. Backup dulu (JANGAN LANGSUNG DELETE)
CREATE TABLE borrowing_returns_backup AS
SELECT * FROM borrowing_returns;

-- 2. Delete orphaned records
DELETE FROM borrowing_returns
WHERE borrowing_id NOT IN (SELECT id FROM borrowings);

-- 3. Verify
SELECT COUNT(*) FROM borrowing_returns
WHERE borrowing_id NOT IN (SELECT id FROM borrowings);
-- Should be 0
```

---

### **Jika Borrowing Status Belum Kembali ke 'approved':**

```sql
-- Check borrowing status
SELECT id, status, returned_at FROM borrowings
WHERE status NOT IN ('approved', 'returned', 'pending');

-- Jika ada status aneh, check logs
-- Normalmente hanya perlu reset satu field:
UPDATE borrowings
SET status = 'approved', returned_at = NULL
WHERE id = X AND status != 'returned';
```

---

## 📊 DATA INTEGRITY CHECKLIST

Jalankan full verification:

```sql
-- 1. No orphaned borrowing_returns
SELECT COUNT(*) as orphaned FROM borrowing_returns
WHERE borrowing_id NOT IN (SELECT id FROM borrowings);
-- Expected: 0

-- 2. All borrowing_returns have valid condition
SELECT COUNT(*) as invalid_condition FROM borrowing_returns
WHERE condition NOT IN ('baik', 'rusak_ringan', 'rusak_sedang', 'rusak_berat');
-- Expected: 0

-- 3. All damage_amount >= 0
SELECT COUNT(*) as negative_damage FROM borrowing_returns
WHERE damage_amount < 0;
-- Expected: 0

-- 4. All payment_status is valid
SELECT COUNT(*) as invalid_status FROM borrowing_returns
WHERE payment_status NOT IN ('paid', 'unpaid');
-- Expected: 0

-- 5. Borrowings with borrowing_returns have status 'returned'
SELECT COUNT(*) as wrong_status FROM borrowings b
INNER JOIN borrowing_returns br ON b.id = br.borrowing_id
WHERE b.status != 'returned';
-- Expected: 0

-- 6. All returned borrowings have returned_at set
SELECT COUNT(*) as no_returned_at FROM borrowings
WHERE status = 'returned' AND returned_at IS NULL;
-- Expected: 0
```

---

## 🚨 POTENTIAL DATA ISSUES & FIXES

### **Issue 1: Borrowing Status 'approved' but BorrowingReturn Exists**

**Symptoms:**
```sql
SELECT * FROM borrowings b
INNER JOIN borrowing_returns br ON b.id = br.borrowing_id
WHERE b.status = 'approved';  -- Should be 'returned'!
```

**Fix:**
```sql
UPDATE borrowings b
INNER JOIN borrowing_returns br ON b.id = br.borrowing_id
SET b.status = 'returned', b.returned_at = br.created_at
WHERE b.status = 'approved';
```

---

### **Issue 2: Missing returned_at When Status is 'returned'**

**Symptoms:**
```sql
SELECT * FROM borrowings
WHERE status = 'returned' AND returned_at IS NULL;
```

**Fix:**
```sql
UPDATE borrowings
SET returned_at = CURRENT_TIMESTAMP
WHERE status = 'returned' AND returned_at IS NULL;
```

---

### **Issue 3: Equipment qty_available Wrong After Return**

**Check:**
```sql
SELECT
    e.id,
    e.name,
    e.qty_total,
    e.qty_available,
    (SELECT COUNT(*) FROM borrowings b
     WHERE b.equipment_id = e.id AND b.status = 'approved') as borrowed_qty
FROM equipments e
ORDER BY e.id;
```

**Expected:** `qty_available + borrowed_qty = qty_total`

**Fix (kalau ada gap):**
```sql
-- Calculate correct qty_available
UPDATE equipments e
SET qty_available = (
    e.qty_total - (
        SELECT COALESCE(SUM(b.qty), 0)
        FROM borrowings b
        WHERE b.equipment_id = e.id AND b.status = 'approved'
    )
)
WHERE id = [equipment_id];
```

---

## 🔄 FULL DATABASE CLEANUP (Jika Diperlukan)

### **WARNING: Hanya jalankan jika ada kasus ekstrem!**

```sql
-- 1. Backup everything
CREATE TABLE borrowing_returns_backup AS SELECT * FROM borrowing_returns;
CREATE TABLE borrowings_backup AS SELECT * FROM borrowings;
CREATE TABLE equipments_backup AS SELECT * FROM equipments;

-- 2. Delete data dengan masalah
DELETE FROM borrowing_returns WHERE borrowing_id NOT IN (SELECT id FROM borrowings);

-- 3. Fix borrowing status yang belum di-update saat borrowing_returns dibuat
UPDATE borrowings b
INNER JOIN borrowing_returns br ON b.id = br.borrowing_id
SET b.status = 'returned',
    b.returned_at = IF(b.returned_at IS NULL, br.created_at, b.returned_at)
WHERE b.status != 'returned';

-- 4. Recalculate equipment qty_available
UPDATE equipments e
SET qty_available = (
    e.qty_total - (
        SELECT COALESCE(SUM(b.qty), 0)
        FROM borrowings b
        WHERE b.equipment_id = e.id AND b.status = 'approved'
    )
);

-- 5. Verify
-- Run all checks dari "DATA INTEGRITY CHECKLIST" section
```

---

## 📝 AFTER FIX VERIFICATION

Setelah menerapkan perbaikan, jalankan:

```bash
# 1. Pilih test data (borrowing yang akan di-return)
SELECT id, equipment_id, user_id, status
FROM borrowings
WHERE status = 'approved'
LIMIT 1;

# 2. Submit pengembalian via modal
# 3. Check results:

SELECT * FROM borrowing_returns
WHERE borrowing_id = [test_id];  # Should exist with correct data

SELECT * FROM borrowings
WHERE id = [test_id];  # Status should be 'returned'

SELECT qty_available FROM equipments
WHERE id = [equipment_id];  # Qty should increase
```

---

## ✅ FINAL VERIFICATION SCRIPT (Copy-Paste Friendly)

```sql
-- Run this after fix to verify everything is OK
SELECT
    '=== BORROWING_RETURNS CHECK ===' as check_name,
    COUNT(*) as total_records
FROM borrowing_returns

UNION ALL

SELECT
    'Orphaned Records Check',
    COUNT(*)
FROM borrowing_returns
WHERE borrowing_id NOT IN (SELECT id FROM borrowings)

UNION ALL

SELECT
    'Invalid Conditions Check',
    COUNT(*)
FROM borrowing_returns
WHERE condition NOT IN ('baik', 'rusak_ringan', 'rusak_sedang', 'rusak_berat')

UNION ALL

SELECT
    'Negative Damage Check',
    COUNT(*)
FROM borrowing_returns
WHERE damage_amount < 0

UNION ALL

SELECT
    'Returned Borrowings without Status',
    COUNT(*)
FROM borrowings
WHERE status = 'returned' AND returned_at IS NULL

UNION ALL

SELECT
    'BorrowingReturn with Wrong Borrowing Status',
    COUNT(*)
FROM borrowings b
INNER JOIN borrowing_returns br ON b.id = br.borrowing_id
WHERE b.status != 'returned';

-- If all counts are 0, database is CLEAN ✅
```

---

## 📞 EMERGENCY CONTACTS

Jika data benar-benar corrupt:

1. **DO NOT DELETE** - Backup dulu
2. **Check logs** - `storage/logs/laravel.log`
3. **Restore from backup** - Jika ada daily backup
4. **Run recovery procedures** - Di atas
5. **Contact developer** - Jika perlu manual fix

---

**Safety Status:** ✅ DATA SAFE (Perbaikan tidak menghapus existing data)
**Recovery Risk:** ✅ LOW (Simple SQL queries)
**Verification:** Easy (SQL scripts provided)
