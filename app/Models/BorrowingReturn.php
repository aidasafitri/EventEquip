<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingReturn extends Model
{
    protected $table = 'borrowing_returns';

    protected $fillable = [
        'borrowing_id',
        'condition',
        'notes',
        'damage_amount',
        'payment_status',
        'paid_date',
    ];

    protected $casts = [
        'damage_amount' => 'decimal:2',
        'paid_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: BorrowingReturn belongs to Borrowing
     */
    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    /**
     * Check if fine is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if fine is unpaid
     */
    public function isUnpaid(): bool
    {
        return $this->payment_status === 'unpaid';
    }

    /**
     * Get condition label in Indonesian
     */
    public function getConditionLabel(): string
    {
        return match ($this->condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_sedang' => 'Rusak Sedang',
            'rusak_berat' => 'Rusak Berat',
            default => 'Unknown',
        };
    }
}
