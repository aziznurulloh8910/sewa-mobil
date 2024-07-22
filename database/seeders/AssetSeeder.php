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


            // Data Tambahan
            [
                'name' => 'P.C Unit',
                'asset_code' => '1.3.2.10.01.02.001',
                'procurement_year' => 2014,
                'acquisition_cost' => 4878500,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Rak Besi/Metal',
                'asset_code' => '1.3.2.05.01.04.003',
                'procurement_year' => 2013,
                'acquisition_cost' => 3960000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Laptop',
                'asset_code' => '1.3.2.10.01.02.002',
                'procurement_year' => 2019,
                'acquisition_cost' => 11000000,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'Meja Kerja Pegawai Non Struktural',
                'asset_code' => '1.3.2.05.03.01.008',
                'procurement_year' => 2022,
                'acquisition_cost' => 2980000,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Gitar Electrik',
                'asset_code' => '1.3.2.08.03.10.002',
                'procurement_year' => 2012,
                'acquisition_cost' => 3245000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'P.C Unit',
                'asset_code' => '1.3.2.10.01.02.001',
                'procurement_year' => 2014,
                'acquisition_cost' => 4878500,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'Note Book',
                'asset_code' => '1.3.2.10.01.02.003',
                'procurement_year' => 2013,
                'acquisition_cost' => 4950000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Proyektor BenQ M5506P',
                'asset_code' => '1.3.2.05.01.05.043',
                'procurement_year' => 2019,
                'acquisition_cost' => 5000000,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'P.C Unit',
                'asset_code' => '1.3.2.10.01.02.001',
                'procurement_year' => 2014,
                'acquisition_cost' => 4878500,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'DISPENSER',
                'asset_code' => '1.3.2.05.02.06.038',
                'procurement_year' => 2020,
                'acquisition_cost' => 5000000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'AC Split',
                'asset_code' => '1.1.7.02.02.02.003',
                'procurement_year' => 2014,
                'acquisition_cost' => 4873000,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'Slide Projector',
                'asset_code' => '1.3.2.05.01.05.043',
                'procurement_year' => 2013,
                'acquisition_cost' => 11907500,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'LapTop',
                'asset_code' => '1.3.2.10.01.02.002',
                'procurement_year' => 2016,
                'acquisition_cost' => 9625000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Lemari Besi',
                'asset_code' => '1.3.2.05.01.04.001',
                'procurement_year' => 2016,
                'acquisition_cost' => 3355000,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'Automatic Chart Proyektor',
                'asset_code' => '1.3.2.07.01.01.029',
                'procurement_year' => 2022,
                'acquisition_cost' => 22000000,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Loudspeaker',
                'asset_code' => '1.3.2.05.02.06.007',
                'procurement_year' => 2022,
                'acquisition_cost' => 6500000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Kamera Digital',
                'asset_code' => '1.3.2.05.02.06.001',
                'procurement_year' => 2015,
                'acquisition_cost' => 8000000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Printer',
                'asset_code' => '1.3.2.10.01.02.004',
                'procurement_year' => 2018,
                'acquisition_cost' => 3000000,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'Scanner',
                'asset_code' => '1.3.2.10.01.02.005',
                'procurement_year' => 2017,
                'acquisition_cost' => 5000000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Monitor LCD',
                'asset_code' => '1.3.2.10.01.02.006',
                'procurement_year' => 2020,
                'acquisition_cost' => 7000000,
                'condition' => 1, // Baik
            ],
            [
                'name' => 'Proyektor NEC',
                'asset_code' => '1.3.2.05.01.05.044',
                'procurement_year' => 2021,
                'acquisition_cost' => 12000000,
                'condition' => 3, // Rusak Berat
            ],
            [
                'name' => 'PC All-in-One',
                'asset_code' => '1.3.2.10.01.02.007',
                'procurement_year' => 2016,
                'acquisition_cost' => 15000000,
                'condition' => 2, // Rusak Ringan
            ],
            [
                'name' => 'Proyektor Epson',
                'asset_code' => '1.3.2.05.01.05.045',
                'procurement_year' => 2019,
                'acquisition_cost' => 9000000,
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