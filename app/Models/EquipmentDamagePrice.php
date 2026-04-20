<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentDamagePrice extends Model
{
    protected $table = 'equipment_damage_prices';

    protected $fillable = [
        'equipment_id',
        'damage_type',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: EquipmentDamagePrice belongs to Equipment
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Get damage type label in Indonesian
     */
    public function getDamageTypeLabel(): string
    {
        return match ($this->damage_type) {
            'ringan' => 'Rusak Ringan',
            'sedang' => 'Rusak Sedang',
            'berat' => 'Rusak Berat',
            default => 'Unknown',
        };
    }
}
