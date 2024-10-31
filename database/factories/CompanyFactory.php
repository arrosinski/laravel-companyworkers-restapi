<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => fake()->company(),
            'tax_identification_number' => fake()->unique()->numerify('#########'),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
        ];
    }
}
