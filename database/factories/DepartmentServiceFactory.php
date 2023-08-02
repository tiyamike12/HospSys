<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\DepartmentService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepartmentService>
 */
class DepartmentServiceFactory extends Factory
{
    protected $model = DepartmentService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = Department::firstOrCreate([
            'department_name' => 'Default Department',
            'description' => 'Default Department Description',
        ]);

        return [
            'service_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'department_id' => $department->id,
        ];
    }
}
