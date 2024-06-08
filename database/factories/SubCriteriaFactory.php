<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SubCriteria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCriteria>
 */
class SubCriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = SubCriteria::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'score' => $this->faker->numberBetween(1, 5),
            'criteria_id' => \App\Models\Criteria::factory(),
        ];
    }
}
