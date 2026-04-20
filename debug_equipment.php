<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

use App\Models\Equipment;

$equipment = Equipment::with('damagePrices')->first();
if ($equipment) {
    echo "Equipment ID: " . $equipment->id . "\n";
    echo "Equipment Name: " . $equipment->name . "\n";
    echo "Only method result: " . json_encode($equipment->only('id', 'damagePrices')) . "\n\n";
    echo "DamagePrices count: " . count($equipment->damagePrices) . "\n";
    foreach ($equipment->damagePrices as $price) {
        echo "  - " . $price->damage_type . ": Rp " . number_format($price->price, 0) . "\n";
    }

    echo "\n--- Testing toArray() ---\n";
    echo json_encode($equipment->toArray()) . "\n";

} else {
    echo "No equipment found\n";
}
?>
