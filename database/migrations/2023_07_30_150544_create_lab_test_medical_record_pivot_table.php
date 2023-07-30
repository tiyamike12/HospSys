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
        Schema::create('lab_test_medical_record', function (Blueprint $table) {
            $table->unsignedBigInteger('lab_test_id');
            $table->unsignedBigInteger('medical_record_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Define foreign keys
            $table->foreign('lab_test_id')->references('id')->on('lab_tests')->onDelete('cascade');
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_medical_record');
    }
};
