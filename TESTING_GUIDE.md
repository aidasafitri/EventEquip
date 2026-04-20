# 🧪 STEP-BY-STEP TESTING GUIDE

## Cara Testing Modal Overlay Fix

---

## ✅ TEST 1: Modal Muncul Sebagai Overlay

### **Langkah-langkah:**

1. **Buka halaman monitoring**
   - Masuk ke: `http://ukk-aida.test/petugas/borrowings/monitoring`
   - Login sebagai petugas jika diperlukan

2. **Klik button "Dikembalikan" di salah satu baris**
   - Lihat tabel "Pantau Pengembalian Alat"
   - Cari button hijau "Dikembalikan"
   - Klik button tersebut

### **Yang Harus Terlihat (CORRECT):**
```
✅ Modal muncul di tengah layar FLOATING di ATAS halaman
✅ Background halaman menjadi gelap (semi-transparent black 60% opacity)
✅ Modal tidak bisa di-scroll bersama halaman
✅ Anda TIDAK bisa scroll halaman di belakang modal
✅ Modal fixed di viewport, tidak bergerak saat scroll
```

### **Yang TIDAK Boleh Terjadi (BROKEN):**
```
❌ Modal muncul di urutan normal halaman (bukan overlay)
❌ Modal muncul di bawah tabel atau konten lain
❌ Halaman bisa di-scroll melalui modal
❌ Modal bergeser saat halaman di-scroll
❌ Z-index issue (modal di belakang elemen lain)
```

---

## ✅ TEST 2: Form Functionality

### **Verifikasi Data Modal:**

1. **Check informasi yang ditampilkan:**
   ```
   ✅ Nama peminjam (ambil dari kolom PEMINJAM)
   ✅ Nama alat (ambil dari kolom ALAT)
   ✅ Tanggal kembali (ambil dari kolom TANGGAL KEMBALI)
   ```

2. **Check dropdown kondisi barang:**
   ```
   ✅ Pilihan 1: Baik (Tanpa Denda)
   ✅ Pilihan 2: Rusak Ringan
   ✅ Pilihan 3: Rusak Sedang
   ✅ Pilihan 4: Rusak Berat
   ```

3. **Test dropdown selection:**
   - Pilih "Rusak Ringan"
   - **Expect:** Denda otomatis muncul di bawah
   - **Format:** "Rp 20.000" (sesuai dengan damage price)

4. **Test textarea catatan:**
   - Ketik beberapa karakter di "Catatan Kerusakan"
   - **Expect:** Bisa diketik normal, textarea resizable

---

## ✅ TEST 3: Modal Close Functionality

### **Test Close Button:**

1. **Klik X button (close icon) di header modal**
   - **Expect:** Modal tertutup
   - **Expect:** Background halaman kembali normal
   - **Expect:** Halaman bisa di-scroll lagi

### **Test Cancel Button:**

1. **Klik button "Batal" di bawah modal**
   - **Expect:** Modal tertutup
   - **Expect:** Form reset (kosongkan nilai)

### **Test Click Outside (Backdrop):**

1. **Klik area background hitam (di luar modal box)**
   - **Expect:** Modal tertutup

### **Test Escape Key:**

1. **Buka modal**
2. **Tekan tombol "Escape" di keyboard**
   - **Expect:** Modal tertutup

---

## ✅ TEST 4: Form Submission - Success Case

### **Langkah:**

1. **Buka modal**
2. **Pilih kondisi: "Baik (Tanpa Denda)"**
3. **Klik "Simpan Pengembalian"**

### **Expected Result:**
```
✅ Loading indicator (button text berubah jadi "Memproses...")
✅ SetelahAPI respond: Alert success muncul
✅ Alert text: "Pengembalian berhasil dicatat!"
✅ Halaman auto-reload setelah 1 detik
✅ Modal tertutup
✅ Row yang dikembalikan hilang dari tabel (status changed)
```

### **Backend Verification:**
```bash
mysql> SELECT * FROM borrowing_returns
       WHERE borrowing_id = [ID dari test]
       AND condition = 'baik';

# Expected result:
# - condition: 'baik'
# - damage_amount: 0
# - payment_status: 'paid'
```

---

## ✅ TEST 5: Form Submission - Damage Case

### **Langkah:**

1. **Buka modal**
2. **Pilih kondisi: "Rusak Sedang"**
3. **Lihat denda yang ditampilkan (contoh: Rp 50.000)**
4. **Isi catatan (optional): "Meja retak di sudut"**
5. **Klik "Simpan Pengembalian"**

### **Expected Result:**
```
✅ Alert success: "Pengembalian berhasil dicatat!"
✅ Alert menampilkan: "Kondisi: Rusak Sedang"
✅ Alert menampilkan: "Denda: Rp 50.000"
✅ Halaman reload
✅ Item pindah ke section "Pengembalian Belum Lunas"
✅ Tombol "Lunas" muncul di section fines
```

### **Backend Verification:**
```bash
mysql> SELECT * FROM borrowing_returns
       WHERE borrowing_id = [ID dari test]
       AND condition = 'rusak_sedang';

# Expected result:
# - condition: 'rusak_sedang'
# - damage_amount: 50000 (atau sesuai konfigurasi)
# - payment_status: 'unpaid'
# - notes: 'Meja retak di sudut'
```

---

## ✅ TEST 6: Form Validation

### **Test: Submit tanpa pilih kondisi**

1. **Buka modal**
2. **Jangan pilih kondisi apapun**
3. **Klik "Simpan Pengembalian"**

### **Expected Result:**
```
✅ Error message muncul: "Pilih kondisi alat terlebih dahulu"
✅ Message berwarna merah
✅ Form TIDAK submit
✅ Halaman TIDAK reload
```

---

## ✅ TEST 7: Modal Appearance & Styling

### **Check Visual Design:**

```
Modal Wrapper:
✅ Background: Semi-transparent black (opacity 60%)
✅ Size: Center screen, max-width 448px (max-w-md)
✅ Border: Rounded corners (rounded-xl)
✅ Shadow: Prominent shadow (shadow-2xl)

Header:
✅ Background: White
✅ Text: "Form Pengembalian Alat" (bold, size xl)
✅ Close icon: X button (top-right)
✅ Bottom border: Subtle gray line

Form Content:
✅ Label: "Kondisi Alat Saat Dikembalikan" dengan red asterisk (*)
✅ Dropdown: Full width, dengan border dan focus ring
✅ Denda display: Amber/orange color, bold amount
✅ Textarea: Placeholder visible, resizable
✅ Spacing: Consistent padding between elements

Buttons:
✅ "Simpan Pengembalian": Green (bg-green-600), full width
✅ "Batal": Gray (bg-gray-200), full width
✅ Button states: Hover effect (darker color)
✅ Button spacing: Gap between buttons
```

---

## ✅ TEST 8: Responsive Design

### **Test di berbagai ukuran:**

1. **Desktop (1920px width)**
   - Modal centered
   - Full visibility
   - All elements visible

2. **Tablet (768px width)**
   - Modal still centered
   - Responsive padding (p-4)
   - Touch-friendly buttons

3. **Mobile (375px width)**
   - Modal adaptive
   - Padding prevents edge-edge
   - Buttons stacked properly
   - No horizontal scroll

### **Expected:**
```
✅ Modal centered di semua ukuran
✅ Modal max-width respected (448px max)
✅ No content overflow
✅ Mobile-friendly touch targets (min 44px)
```

---

## ✅ TEST 9: No Breaking Changes

### **Test Komponen Lain:**

1. **Sidebar**
   - ✅ Masih visible di belakang modal
   - ✅ Masih clickable setelah modal close
   - ✅ No styling changes

2. **Header Navigation**
   - ✅ Logo visible
   - ✅ User name visible
   - ✅ Logout button works
   - ✅ Modal tidak menutupi (z-index correct)

3. **Main Table**
   - ✅ Tabel masih visible di belakang modal
   - ✅ Pagination works
   - ✅ Button lain (Lunas) masih clickable

4. **Fine Payment Section**
   - ✅ "Pengembalian Belum Lunas" tetap berfungsi
   - ✅ "Lunas" button works
   - ✅ Payment flow tidak terganggu

---

## ✅ TEST 10: Multiple Modal Opens

### **Procedure:**

1. **Buka modal > Close > Buka lagi**
   - Repeat 5x
   - **Expect:** Konsisten, tidak ada memory leak

2. **Buka modal dari row A > Close > Buka dari row B**
   - **Expect:** Data benar (dari row B, bukan row A)
   - **Expect:** Form reset sempurna

3. **Buka modal > Submit success > Reload > Buka modal lagi**
   - **Expect:** Item sudah hilang dari list (status changed)
   - **Expect:** Modal bisa dibuka untuk item lain

---

## 🔍 Browser Developer Tools Testing

### **Test di Console:**

```javascript
// Check modal element exists
document.getElementById('returnModal')
// Result: Should return the modal element, not null

// Check hidden class toggle
document.getElementById('returnModal').classList.contains('hidden')
// Result: true = hidden, false = visible

// Check if fixed positioning active
window.getComputedStyle(document.getElementById('returnModal')).position
// Result: "fixed"

// Check z-index
window.getComputedStyle(document.getElementById('returnModal')).zIndex
// Result: "50"
```

### **Check Network:**

```
POST /petugas/borrowings/{id}/returned
Status: 200
Response: { success: true, condition_label: "...", damage_amount: ... }
```

---

## ✅ FINAL CHECKLIST

**Sebelum declare "FIXED":**

```
✅ Modal appears as overlay (floating, not in document flow)
✅ Background properly semi-transparent
✅ Modal centered on screen
✅ Close button works (X, Batal, outside click, Escape)
✅ Form data populated correctly
✅ Dropdown shows 4 options
✅ Damage amount displays when condition selected
✅ Submit works and reloads page
✅ Validation works (requires condition)
✅ Responsive on mobile/tablet
✅ No CSS native code found
✅ Tailwind classes only used
✅ No breaking changes to other UI
✅ Multiple open/close cycles work smoothly
```

---

## 🐛 If Test Fails

### **Scenario: Modal still appears in document flow**

**Solution:**
1. Check: Is `@include` in layout.blade.php or monitoring.blade.php?
   - Should be in `layouts/app.blade.php` line 67
   - Should NOT be in `monitoring.blade.php`

2. Check: Is `<main>` still has `overflow-y-auto`?
   - It should! (that's normal and expected)

3. Check: Class on modal div?
   - Must have: `fixed top-0 left-0 right-0 bottom-0`
   - Must NOT have: Just `fixed inset-0` (old approach)

### **Scenario: Modal has CSS animation issues**

**Solution:**
1. Check: Is there a `<style>` tag in return-modal.blade.php?
   - Should be NONE
   - If found, delete it

2. Open DevTools → Sources → find return-modal.blade.php
   - Look for `<style>` section
   - Should be gone entirely

### **Scenario: Modal behind other elements**

**Solution:**
- Check z-index: `z-50` on returnModal
- Check if any parent has `z-index: 40` or higher (shouldn't)
- Check if any element has `overflow: hidden` (shouldn't affect fixed)

---

## 📞 Support

If you find any issues during testing:

1. Take screenshot
2. Check browser console for errors
3. Check HTML structure in DevTools
4. Verify Tailwind classes are present
5. Confirm no CSS native code exists
6. Compare with IMPLEMENTATION_SUMMARY.md

---

**Testing Date:** 2026-04-09
**Status:** Ready for testing
**Expected Result:** ✅ ALL TESTS PASS
