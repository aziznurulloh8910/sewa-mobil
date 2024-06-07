<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aset>
 */
class AsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'registration_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'asset_code' => $this->faker->unique()->bothify('ASSET-###??'),
            'location' => $this->faker->city,
            'brand_type' => $this->faker->company,
            'procurement_year' => $this->faker->year,
            'quantity' => $this->faker->numberBetween(1, 100),
            'acquisition_cost' => $this->faker->numberBetween(100000,100000000),
            'recorded_value' => $this->faker->numberBetween(100000,100000000),
            'accumulated_depreciation' => $this->faker->numberBetween(100000,100000000),
            'total_depreciation' => $this->faker->numberBetween(1,100),
            'condition' => $this->faker->numberBetween(1, 4),
            'description' => $this->faker->sentence
        ];
    }
}
