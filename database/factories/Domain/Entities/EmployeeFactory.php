<?php
declare(strict_types=1);

namespace Database\Factories\Domain\Entities;

use App\Domain\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company_id' => fake()->numberBetween(1, 100),
        ];
    }
}
