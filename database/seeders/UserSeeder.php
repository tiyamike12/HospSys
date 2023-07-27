<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new role (You can replace 'System Administrator' with the desired role name)
        $role = Role::create([
            'name' => 'system_administrator',
        ]);

        // Create and insert the default user as a staff member with the job title 'System Administrator'
        $user = User::create([
            'username' => 'tnkhono',
            'password' => Hash::make('Password123.'),
            'role_id' => $role->id,
        ]);

        $person = Person::create([
            'firstname' => 'System',
            'lastname' => 'Administrator',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'email' => 'admin@localhost.com',
            'phone' => '0991664423',
            'physical_address' => '123 Main St',
            'user_id' => $user->id
        ]);

        Staff::create([
            'person_id' => $person->id,
            'job_title' => 'System Administrator',
        ]);
    }

}
