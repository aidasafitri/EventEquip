# 🔧 ERROR FIX ANALYSIS & SOLUTION

## 📋 ERROR REPORT

**Error Message:** `Unexpected token '<', "<!DOCTYPE "... is not valid JSON`

**Kemunculan:** Saat mengklik "Simpan Pengembalian" di modal

---

## 🔍 ROOT CAUSE ANALYSIS (DEPTH)

### **Problem Identification:**

```
JavaScript Request:
  fetch('/petugas/borrowings/{id}/returned', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',  ← Kirim JSON
      'X-CSRF-TOKEN': '...'
    }
  })

Server Response:
  ❌ HTML Error Page (<!DOCTYPE html>...)  ← Expected JSON!

JavaScript Parser:
  const data = await response.json()
  ↓
  ❌ Cannot parse HTML as JSON
  ↓
  ERROR: Unexpected token '<'
```

### **Penyebab Teknisnya:**

#### **1. Validation Error (Primary Cause)**
```php
// Sebelum:
$validated = $request->validate([...]);
// Jika validation gagal, Laravel return HTML 422 response
// Tidak konsisten dengan JSON request!
```

#### **2. Status Check Error**
```php
// Sebelum:
if ($borrowing->status !== 'approved') {
    return back()->withErrors(...);  // ← Return view (HTML!)
    // Tapi request expect JSON
}
```

#### **3. No Exception Handling for Errors**
```php
// Sebelum: Tidak ada try-catch
// Jika ada exception, Laravel return HTML error page
```

---

## ✅ SOLUSI YANG DIIMPLEMENTASIKAN

### **1. Add Proper Exception Handling**

**File:** `app/Http/Controllers/Petugas/BorrowingController.php`

```php
public function markReturned(Request $request, $id)
{
    try {
        // ... validation dan business logic ...

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengembalian berhasil dicatat',
                'damage_amount' => $damageAmount,
                'condition_label' => $borrowingReturn->getConditionLabel(),
            ]);
        }

        return redirect(...);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // ✅ HANDLE VALIDATION ERROR
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);  // ← JSON response, tidak HTML!
        }
        throw $e;

    } catch (\Exception $e) {
        // ✅ HANDLE ANY EXCEPTION
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);  // ← JSON response!
        }
        throw $e;
    }
}
```

**Key Points:**
- ✅ Semua error path return JSON jika request expectsJson()
- ✅ Consistent error format
- ✅ Proper HTTP status codes (400, 422, 500)
- ✅ No HTML error pages

### **2. Add Status Check JSON Response**

```php
if ($borrowing->status !== 'approved') {
    $errorMessage = 'Hanya peminjaman yang sudah disetujui...';

    // ✅ Check request type
    if ($request->expectsJson()) {
        return response()->json([
            'success' => false,
            'message' => $errorMessage,
        ], 400);  // ← JSON, bukan view!
    }
    return back()->withErrors($errorMessage);
}
```

### **3. Improve JavaScript Error Handling**

**File:** `resources/views/petugas/borrowings/return-modal.blade.php`

```javascript
try {
    const response = await fetch(`/petugas/borrowings/${borrowingId}/returned`, {
        // ... request setup ...
    });

    // ✅ CHECK RESPONSE STATUS
    if (!response.ok) {
        const contentType = response.headers.get('content-type');

        if (contentType && contentType.includes('application/json')) {
            // ✅ Server returned JSON error
            const data = await response.json();

            if (data.errors) {
                // Validation errors dari server
                const errorList = Object.values(data.errors).flat().join(', ');
                alert('Validasi gagal:\n' + errorList);
            } else {
                alert('Error: ' + data.message);
            }
        } else {
            // ✅ Server returned HTML (error page)
            // This should not happen anymore, but we handle it
            throw new Error(`Server error: ${response.status}`);
        }
        return;
    }

    // ✅ PARSE SUCCESSFUL RESPONSE
    const data = await response.json();

    if (data.success) {
        closeReturnModal();
        alert(`✓ Pengembalian berhasil dicatat!`);
        setTimeout(() => window.location.reload(), 1500);
    }
} catch (error) {
    console.error('Error details:', error);
    alert('Terjadi kesalahan: ' + error.message);
}
```

**Improvements:**
- ✅ Check `response.ok` sebelum parse JSON
- ✅ Handle content-type untuk detect JSON vs HTML
- ✅ Better error messages dengan validation error details
- ✅ Proper console logging untuk debugging

---

## 📊 CHANGES SUMMARY

### **File 1: `app/Http/Controllers/Petugas/BorrowingController.php`**

```diff
  public function markReturned(Request $request, $id)
  {
+     try {
          $borrowing = Borrowing::findOrFail($id);

          if ($borrowing->status !== 'approved') {
+             if ($request->expectsJson()) {
+                 return response()->json([...], 400);
+             }
              return back()->withErrors(...);
          }

          // ... rest of logic ...
+     } catch (\Illuminate\Validation\ValidationException $e) {
+         if ($request->expectsJson()) {
+             return response()->json([...], 422);
+         }
+         throw $e;
+     } catch (\Exception $e) {
+         if ($request->expectsJson()) {
+             return response()->json([...], 500);
+         }
+         throw $e;
+     }
  }
```

**Status:** ✅ COMPLETE

---

### **File 2: `resources/views/petugas/borrowings/return-modal.blade.php`**

```diff
  document.getElementById('returnForm').addEventListener('submit', async function(e) {
      // ...
      try {
          const response = await fetch(...);
+
+         if (!response.ok) {
+             const contentType = response.headers.get('content-type');
+             if (contentType && contentType.includes('application/json')) {
+                 const data = await response.json();
+                 // Handle validation/error responses
+             } else {
+                 throw new Error(`Server error: ${response.status}`);
+             }
+             return;
+         }

          const data = await response.json();
+         // ... better success handling ...
      } catch (error) {
+         console.error('Error details:', error);
          alert('Terjadi kesalahan: ' + error.message);
      }
  });
```

**Status:** ✅ COMPLETE

---

## 🧪 TESTING PROCEDURE

### **Pre-Testing:**

```bash
# 1. Clear browser cache
# 2. Ensure no debugging/error display in .env
APP_DEBUG=true  (untuk development, show detailed errors)

# 3. Check logs
tail -f storage/logs/laravel.log
```

### **Test Case 1: Valid Submission**

1. **Open page:** `/petugas/borrowings/monitoring`
2. **Click "Dikembalikan" button**
3. **Select condition:** "Baik (Tanpa Denda)"
4. **Click "Simpan Pengembalian"**

**Expected Result:**
```
✅ Modal tetap terbuka sebentar (processing)
✅ Alert muncul: "✓ Pengembalian berhasil dicatat!"
✅ Page reload setelah 1.5 detik
✅ Item hilang dari "Pantau Pengembalian" table
✅ Tidak ada HTML parsing error
```

**Verify Database:**
```sql
SELECT * FROM borrowing_returns
WHERE borrowing_id = [ID dari test]
-- Expected:
-- condition: 'baik'
-- damage_amount: 0
-- payment_status: 'paid'
```

---

### **Test Case 2: Damage Submission**

1. **Open page:** `/petugas/borrowings/monitoring`
2. **Click "Dikembalikan"**
3. **Select condition:** "Rusak Sedang"
4. **Type notes:** "Retak di bagian belakang"
5. **Click "Simpan Pengembalian"**

**Expected Result:**
```
✅ Alert shows damage amount: "Denda: Rp 50.000"
✅ Modal closes, page reloads
✅ Item moves to "Pengembalian Belum Lunas" section
✅ No JSON parsing error
```

**Verify Database:**
```sql
SELECT * FROM borrowing_returns
WHERE borrowing_id = [ID dari test]
-- Expected:
-- condition: 'rusak_sedang'
-- damage_amount: 50000 (or configured value)
-- payment_status: 'unpaid'
-- notes: 'Retak di bagian belakang'
```

---

### **Test Case 3: Validation Error (No Condition Selected)**

1. **Open modal**
2. **Don't select condition**
3. **Click "Simpan Pengembalian"**

**Expected Result:**
```
✅ Client-side validation works:
   Error message: "Pilih kondisi alat terlebih dahulu"
   Modal tetap terbuka

✅ If somehow passed, server returns:
   JSON response (not HTML error page)
   Alert shows: "Validasi gagal: condition field required"
```

---

### **Test Case 4: Browser DevTools Verification**

1. **Open DevTools (F12)**
2. **Go to Network tab**
3. **Click "Simpan Pengembalian"**
4. **Check POST request:**

```
Request:
  URL: /petugas/borrowings/{id}/returned
  Method: POST
  Headers: Content-Type: application/json
  Payload: { condition: "baik", notes: "" }

Response:
  ✅ Status: 200 OK (or appropriate status)
  ✅ Content-Type: application/json
  ✅ Body: { "success": true, "message": "...", ... }
  ❌ NOT: <!DOCTYPE html> (old error)
```

---

### **Test Case 5: Error Scenarios**

#### **5a. Invalid Condition Value**

Modify JavaScript to send invalid condition:
```javascript
body: JSON.stringify({
    condition: "invalid_condition",
    notes: ""
})
```

**Expected:**
```
✅ Server returns 422 JSON:
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "condition": ["The selected condition is invalid."]
  }
}

✅ JavaScript displays:
Alert: "Validasi gagal: The selected condition is invalid."
```

#### **5b. Already Returned Borrowing**

Click "Dikembalikan" on a borrowing that already has status 'returned'

**Expected:**
```
✅ Server returns 400 JSON:
{
  "success": false,
  "message": "Hanya peminjaman yang sudah disetujui..."
}

✅ No HTML error page!
✅ Alert shows proper message
```

---

## 🐛 Debugging Tips

### **If Error Still Occurs:**

1. **Check browser console (F12 → Console):**
   ```
   Look for: "Unexpected token '<'"
   This means server still returning HTML
   ```

2. **Check Network response (F12 → Network):**
   - Click the failed POST request
   - Go to "Response" tab
   - Should be JSON, not HTML
   - If HTML, check error message in response

3. **Check Laravel logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```
   Look for exception traces

4. **Check status code:**
   - 200: Success, check response body
   - 422: Validation error, check validation message
   - 500: Server error, check logs
   - 419: CSRF token issue, check token in request

---

## ✨ KEY IMPROVEMENTS SUMMARY

| Issue | Before | After |
|-------|--------|-------|
| Validation Error | HTML 422 page | JSON 422 response |
| Status Check Error | HTML view response | JSON error response |
| Exception Handling | Unhandled HTML error | JSON error response |
| JS Error Handling | Only parse JSON | Check status + content-type |
| Error Messages | Generic | Specific validation errors |
| Database Safety | Transactions possible | ✅ Rollback on error |

---

## 📝 IMPORTANT NOTES

- ✅ **Database data NOT lost** - Error happens before any commit
- ✅ **CSRF token still valid** - Still checked via middleware
- ✅ **All error paths JSON** - No more HTML error pages for AJAX
- ✅ **Backward compatible** - Non-JSON requests work as before
- ✅ **No breaking changes** - Other features unaffected

---

**Status:** ✅ FIX COMPLETE & READY FOR TESTING
**Date:** 2026-04-09
**Version:** 1.1 (Error Handling Edition)
