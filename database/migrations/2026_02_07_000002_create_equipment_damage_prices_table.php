<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment_damage_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->enum('damage_type', ['ringan', 'sedang', 'berat']);
            $table->decimal('price', 12, 2);
            $table->timestamps();

            // Foreign key
            $table->foreign('equipment_id')
                ->references('id')
                ->on('equipments')
                ->cascadeOnDelete();

            // Unique constraint: one damage type per equipment
            $table->unique(['equipment_id', 'damage_type']);

            // Index for faster queries
            $table->index('equipment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_damage_prices');
    }
};
