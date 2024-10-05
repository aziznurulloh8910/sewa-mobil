<?php

namespace Database\Seeders;

use App\Models\Asset;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AssetSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Baca data dari file JSON
        $json = File::get(public_path('app-assets/data/testCasebab3.json'));
        $assets = json_decode($json, true);

        foreach ($assets as $asset) {
            $quantity = $this->faker->numberBetween(1, 100);
            $recordedValue = $asset['acquisition_cost'] * $quantity;
            $currentYear = date('Y');
            $assetAge = $currentYear - $asset['procurement_year'];
            $depresiationValue = ($assetAge * 0.5 * $asset['acquisition_cost']) / 100;
            $accumulatedDepreciation = $asset['acquisition_cost'] - $depresiationValue;
            $totalDepreciation = $assetAge * 0.5;

            Asset::create(array_merge($asset, [
                'user_id' => $this->faker->randomElement([1, 2]),
                'registration_number' => $this->faker->unique()->numberBetween(1000, 9999),
                'location' => $this->faker->city,
                'brand_type' => $this->faker->company,
                'quantity' => $quantity,
                'recorded_value' => $recordedValue,
                'accumulated_depreciation' => $accumulatedDepreciation,
                'total_depreciation' => $totalDepreciation,
                'description' => $this->faker->sentence,
            ]));
        }
    }
}
