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
        Schema::create('emergency_departments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id');
            $table->bigInteger('user_id');
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date');
            $table->string('reason', 100);
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_departments');
    }
};
