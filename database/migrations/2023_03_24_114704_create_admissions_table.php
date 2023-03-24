<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//TODO find out if i can make other entities authenticatable
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id');
            $table->bigInteger('user_id');
            $table->bigInteger('ward_id');
            $table->bigInteger('bed_id');
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date');
            $table->string('admission_reason');
            $table->string('discharge_reason');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
