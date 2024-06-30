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
        $min = mt_rand(0, 250);
        $max = $min + mt_rand(50, 250);
        return [
            'min_value' => $min,
            'max_value' => $max,
            'service_plan' => fake()->sentence(3),
        ];
    }
}
