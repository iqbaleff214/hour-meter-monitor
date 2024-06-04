<?php

namespace Database\Factories;

use App\Models\CategoryRule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CategoryRule>
 */
class CategoryRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'max_value' => mt_rand(0, 100),
            'service_plan' => fake()->sentence(3),
        ];
    }
}
