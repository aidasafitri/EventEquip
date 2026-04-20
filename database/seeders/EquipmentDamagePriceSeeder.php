<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentDamagePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentDamagePriceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed damage prices for all equipment
     * Default prices: ringan=20000, sedang=50000, berat=100000
     */
    public function run(): void
    {
        // Get all equipment
        $equipments = Equipment::all();

        // Define default damage prices
        $damagePrices = [
            ['damage_type' => 'ringan', 'price' => 20000],
            ['damage_type' => 'sedang', 'price' => 50000],
            ['damage_type' => 'berat', 'price' => 100000],
        ];

        // Create damage prices for each equipment
        foreach ($equipments as $equipment) {
            foreach ($damagePrices as $damagePrice) {
                // Check if price already exists to avoid duplicates
                EquipmentDamagePrice::updateOrCreate(
                    [
                        'equipment_id' => $equipment->id,
                        'damage_type' => $damagePrice['damage_type'],
                    ],
                    [
                        'price' => $damagePrice['price'],
                    ]
                );
            }
        }
    }
}
