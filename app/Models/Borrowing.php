<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','equipment_id','qty','start_date','end_date','status','note','approved_by','returned_at'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'returned_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relationship: Borrowing has one BorrowingReturn
     */
    public function borrowingReturn()
    {
        return $this->hasOne(BorrowingReturn::class);
    }

    /**
     * Check if borrowing is late (past end_date and not yet returned)
     */
    public function isLate(): bool
    {
        return $this->end_date->isPast() && $this->status !== 'returned';
    }

    /**
     * Get fine amount for this borrowing
     */
    public function getFineAmount(): float
    {
        if ($this->borrowingReturn) {
            return (float) $this->borrowingReturn->damage_amount;
        }
        return 0.0;
    }

    /**
     * Check if fine is paid
     */
    public function isFinePaid(): bool
    {
        if (!$this->borrowingReturn) {
            return false;
        }
        return $this->borrowingReturn->isPaid();
    }

    /**
     * Check if has unpaid fine
     */
    public function hasUnpaidFine(): bool
    {
        if (!$this->borrowingReturn) {
            return false;
        }
        return $this->borrowingReturn->isUnpaid();
    }
}
