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
        Schema::create('imagings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id');
            $table->bigInteger('user_id');
            $table->dateTime('imaging_date');
            $table->string('imaging_type');
            $table->string('imaging_results');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagings');
    }
};
