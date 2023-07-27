<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'doctor', 'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')],
            ['name' => 'nurse', 'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')],
            ['name' => 'finance_manager', 'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')],
            ['name' => 'pharmacist', 'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')],
        ]);
    }
}
