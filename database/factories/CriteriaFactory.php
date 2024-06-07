<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Criteria>
 */
class CriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;

        return [
            'criteria_code' => 'C' . $id++,
            'name' => $this->faker->name,
            'attribute' => $this->faker->randomElement(['cost', 'benefit']),
            'weight' => $this->faker->numberBetween(1, 5),
        ];
    }
}
