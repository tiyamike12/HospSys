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
        Schema::create('staff_role', function (Blueprint $table) {
            $table->foreignId('staff_id')->constrained('staff');
            $table->foreignId('role_id')->constrained('roles');
            $table->primary(['staff_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_role');
    }
};
