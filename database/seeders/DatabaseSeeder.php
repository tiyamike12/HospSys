<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Patient;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//        $this->call(RoleSeeder::class);
       //$this->call(UserSeeder::class);

       // Patient::factory()->count(200)->create();
        //Appointment::factory()->count(50)->create();
        //User::factory()->count(100)->create();

//        User::factory()
//            ->count(100)
//            ->has(Person::factory())
//            ->create();
        Billing::factory()->count(100)->create();


    }
}
