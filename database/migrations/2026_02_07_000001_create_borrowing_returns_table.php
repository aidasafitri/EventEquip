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
        Schema::create('borrowing_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrowing_id');
            $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_sedang', 'rusak_berat'])->default('baik');
            $table->text('notes')->nullable();
            $table->decimal('damage_amount', 12, 2)->default(0)->comment('Amount of fine in IDR');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamp('paid_date')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('borrowing_id')
                ->references('id')
                ->on('borrowings')
                ->cascadeOnDelete();

            // Index for faster queries
            $table->index('borrowing_id');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_returns');
    }
};
