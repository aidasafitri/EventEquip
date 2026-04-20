<!-- Return Modal - Condition Selection -->
<!-- Fixed positioning with tailwind classes for proper overlay behavior -->
<div id="returnModal" class="hidden fixed top-0 left-0 right-0 bottom-0 z-50 flex items-center justify-center p-4 w-screen h-screen" style="background-color: rgba(0, 0, 0, 0.4);">
    <div class="relative w-full max-w-md bg-white rounded-xl shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-900">Form Pengembalian Alat</h3>
            <button type="button" onclick="closeReturnModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="returnForm" class="space-y-5 p-6 max-h-96 overflow-y-auto">
            @csrf
            <input type="hidden" id="borrowingId" name="borrowing_id">
            <input type="hidden" id="equipmentId" name="equipment_id">

            <div>
                <label for="condition" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kondisi Alat Saat Dikembalikan <span class="text-red-500">*</span>
                </label>
                <select name="condition" id="condition" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white text-gray-900"
                    onchange="updateDamageAmount()">
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="baik">Baik (Tanpa Denda)</option>
                    <option value="rusak_ringan">Rusak Ringan</option>
                    <option value="rusak_sedang">Rusak Sedang</option>
                    <option value="rusak_berat">Rusak Berat</option>
                </select>
                <p id="conditionError" class="mt-2 text-sm text-red-500 hidden"></p>
            </div>

            <!-- Display damage amount -->
            <div id="damageAmountDisplay" class="hidden bg-amber-50 border border-amber-200 rounded-lg p-4">
                <p class="text-sm text-gray-700">
                    <span class="font-semibold text-gray-900">Denda Kerusakan:</span>
                    <span class="text-amber-700 font-bold text-lg ml-2" id="damageAmountText">Rp 0</span>
                </p>
                <p class="text-xs text-gray-600 mt-1">Harga denda sesuai jenis kerusakan barang ini</p>
            </div>

            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                    Catatan Kerusakan <span class="text-gray-500">(Opsional)</span>
                </label>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                    placeholder="Contoh: Meja retak di bagian pojok kanan..."></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition font-semibold shadow-md hover:shadow-lg">
                    Simpan Pengembalian
                </button>
                <button type="button" onclick="closeReturnModal()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Store damage prices
let equipmentDamagePrices = {};

function openReturnModal(borrowingId, equipmentId, equipmentData) {
    document.getElementById('borrowingId').value = borrowingId;
    document.getElementById('equipmentId').value = equipmentId;
    document.getElementById('condition').value = '';
    document.getElementById('notes').value = '';
    document.getElementById('damageAmountDisplay').classList.add('hidden');
    document.getElementById('conditionError').classList.add('hidden');
    document.getElementById('returnModal').classList.remove('hidden');

    // Store damage prices for this equipment
    if (equipmentData && equipmentData.damagePrices) {
        equipmentDamagePrices = {};
        equipmentData.damagePrices.forEach(price => {
            equipmentDamagePrices[price.damage_type] = price.price;
        });
    }

    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function closeReturnModal() {
    document.getElementById('returnModal').classList.add('hidden');
    // Re-enable body scroll
    document.body.style.overflow = 'auto';
}

function updateDamageAmount() {
    const condition = document.getElementById('condition').value;
    const damageDisplay = document.getElementById('damageAmountDisplay');
    const damageAmountText = document.getElementById('damageAmountText');

    if (condition === 'baik') {
        damageDisplay.classList.add('hidden');
    } else {
        damageDisplay.classList.remove('hidden');

        // Extract damage type from condition (e.g., "rusak_ringan" => "ringan")
        const damageType = condition.replace('rusak_', '');
        const amount = equipmentDamagePrices[damageType] || 0;

        damageAmountText.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }
}

// Handle form submission
document.getElementById('returnForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const borrowingId = document.getElementById('borrowingId').value;
    const condition = document.getElementById('condition').value;
    const notes = document.getElementById('notes').value;
    const conditionError = document.getElementById('conditionError');

    if (!condition) {
        conditionError.textContent = 'Pilih kondisi alat terlebih dahulu';
        conditionError.classList.remove('hidden');
        return;
    }

    try {
        const response = await fetch(`/petugas/borrowings/${borrowingId}/returned`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: JSON.stringify({
                condition: condition,
                notes: notes,
            }),
        });

        // Check response status
        if (!response.ok) {
            // Handle HTTP error responses (4xx, 5xx)
            const contentType = response.headers.get('content-type');

            if (contentType && contentType.includes('application/json')) {
                // Response is JSON
                const data = await response.json();
                const errorMsg = data.message || data.errors || 'Terjadi kesalahan saat mencatat pengembalian';

                if (data.errors) {
                    // Validation errors
                    const errorList = Object.values(data.errors).flat().join(', ');
                    Swal.fire({
                        title: 'Validasi Gagal',
                        text: errorList,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error Server',
                    text: `HTTP ${response.status}: ${response.statusText}`,
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
            return;
        }

        // Parse successful response
        const data = await response.json();

        if (data.success) {
            // Close modal
            closeReturnModal();

            // Show success message with details
            const amount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(data.damage_amount);

            Swal.fire({
                title: 'Sukses!',
                html: `<p class="text-lg">Pengembalian berhasil dicatat</p>
                       <p class="mt-3 text-sm text-gray-600">Kondisi: <strong>${data.condition_label}</strong></p>
                       <p class="text-sm text-gray-600">Denda: <strong class="text-red-600">${amount}</strong></p>`,
                icon: 'success',
                confirmButtonColor: '#10b981'
            }).then(() => {
                setTimeout(() => window.location.reload(), 500);
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Terjadi kesalahan saat mencatat pengembalian',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    } catch (error) {
        console.error('Error details:', error);
        Swal.fire({
            title: 'Error',
            text: error.message,
            icon: 'error',
            confirmButtonColor: '#ef4444'
        });
    }
});

// Close modal when clicking outside
document.getElementById('returnModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReturnModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('returnModal').classList.contains('hidden')) {
        closeReturnModal();
    }
});
</script>
