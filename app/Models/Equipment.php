<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = ['category_id','name','code','qty_total','qty_available','condition','description','photo'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Relationship: Equipment has many EquipmentDamagePrice
     */
    public function damagePrices()
    {
        return $this->hasMany(EquipmentDamagePrice::class);
    }

    /**
     * Get damage price for a specific damage type
     * Default prices: ringan=20000, sedang=50000, berat=100000
     */
    public function getDamagePrice(string $damageType): float
    {
        $damagePrice = $this->damagePrices()
            ->where('damage_type', $damageType)
            ->first();

        if ($damagePrice) {
            return (float) $damagePrice->price;
        }

        // Fallback to default prices if no custom price set
        return match ($damageType) {
            'ringan' => 20000.0,
            'sedang' => 50000.0,
            'berat' => 100000.0,
            default => 0.0,
        };
    }

    /**
     * Get photo URL
     */
    public function getPhotoUrl(): string
    {
        if ($this->photo) {
            return asset('storage/equipments/' . $this->photo);
        }
        return asset('images/default-equipment.png');
    }

    /**
     * Get photo path
     */
    public function getPhotoPath(): string
    {
        if ($this->photo) {
            return 'storage/equipments/' . $this->photo;
        }
        return 'images/default-equipment.png';
    }
}
