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
        Schema::table('pharmacy_items', function (Blueprint $table) {
            $table->unsignedInteger('initial_quantity');
            $table->unsignedInteger('current_quantity')->default(0);
            $table->unsignedInteger('threshold_quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pharmacy_items', function (Blueprint $table) {
            //
        });
    }
};
