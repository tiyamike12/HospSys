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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id');
            $table->date('service_date');
            $table->string('service_type', 100);
            $table->decimal('cost', 10, 2);
            $table->string('insurance_information', 100);
            $table->string('payment_status', 20);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
