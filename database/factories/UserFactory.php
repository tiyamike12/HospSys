<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected $model = User::class;

    public function definition()
    {
        // Create a role or use an existing role
        $role = Role::firstOrCreate([
            'name' => 'system_administrator',
        ]);

        return [
            'username' => $this->faker->userName,
            'password' => Hash::make('Password123.'),
            'role_id' => $role->id,
        ];
    }

    public function unverified()
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }
}
