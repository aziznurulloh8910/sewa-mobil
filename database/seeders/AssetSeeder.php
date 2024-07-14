<?php

namespace Database\Seeders;

use App\Models\Asset;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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
        $assets = [
            [
                'name' => 'AC Unit',
                'asset_code' => '1.3.2.10.01.02.001',
                'procurement_year' => 2014,
                'acquisition_cost' => 4878500,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Sound System',
                'asset_code' => '1.3.2.05.02.06.008',
                'procurement_year' => 2011,
                'acquisition_cost' => 4950000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Alat Peraga IPA',
                'asset_code' => '1.3.2.08.03.05.',
                'procurement_year' => 2010,
                'acquisition_cost' => 4980000,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'PC Unit',
                'asset_code' => '1.3.2.10.01.02.001',
                'procurement_year' => 2014,
                'acquisition_cost' => 4878500,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Slide Projector',
                'asset_code' => '1.3.2.05.01.05.043',
                'procurement_year' => 2011,
                'acquisition_cost' => 11907500,
                'condition' => 4, // Barang Tidak Ada
            ],
            [
                'name' => 'Televisi',
                'asset_code' => '1.3.2.05.02.06.002',
                'procurement_year' => 2009,
                'acquisition_cost' => 1870000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'CCTV',
                'asset_code' => '1.3.2.05.01.05.002',
                'procurement_year' => 2022,
                'acquisition_cost' => 1200000,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Alat Pengukur Suhu',
                'asset_code' => '1.3.2.23.99',
                'procurement_year' => 2021,
                'acquisition_cost' => 44000000,
                'condition' => 1, // Baik
            ],
        ];

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