<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition()
    {
        $department = Department::firstOrCreate([
            'department_name' => 'Default Department',
            'description' => 'Default Department Description',
        ]);

        // Create a user or use an existing user
        $user = User::factory()->create();

        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'physical_address' => $this->faker->address,
            'job_title' => $this->faker->jobTitle,
            'department_id' => $department->id,
            'user_id' => $user->id,
        ];
    }
}
