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
        Schema::create('pharmacy_item_stock_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pharmacy_item_id');
            $table->unsignedInteger('quantity_change');
            $table->string('change_type'); // Use 'sale' or 'restock' to indicate the type of change
            $table->timestamps();

            $table->foreign('pharmacy_item_id')->references('id')->on('pharmacy_items')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_item_stock_changes');
    }
};
