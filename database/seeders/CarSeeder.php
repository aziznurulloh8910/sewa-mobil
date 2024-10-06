<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run()
    {
        DB::table('cars')->insert([
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'license_plate' => 'B1234XYZ',
                'rental_rate' => 500000,
                'availability' => true,
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'license_plate' => 'B5678XYZ',
                'rental_rate' => 600000,
                'availability' => true,
            ],
            [
                'brand' => 'Suzuki',
                'model' => 'Swift',
                'license_plate' => 'B9101XYZ',
                'rental_rate' => 450000,
                'availability' => true,
            ],
            [
                'brand' => 'Nissan',
                'model' => 'Juke',
                'license_plate' => 'B1121XYZ',
                'rental_rate' => 550000,
                'availability' => true,
            ],
            [
                'brand' => 'Mitsubishi',
                'model' => 'Pajero',
                'license_plate' => 'B3141XYZ',
                'rental_rate' => 700000,
                'availability' => true,
            ],
            [
                'brand' => 'Mazda',
                'model' => 'CX-5',
                'license_plate' => 'B5161XYZ',
                'rental_rate' => 650000,
                'availability' => true,
            ],
            [
                'brand' => 'Ford',
                'model' => 'Fiesta',
                'license_plate' => 'B7181XYZ',
                'rental_rate' => 500000,
                'availability' => true,
            ],
            [
                'brand' => 'Chevrolet',
                'model' => 'Spark',
                'license_plate' => 'B9201XYZ',
                'rental_rate' => 400000,
                'availability' => true,
            ],
            [
                'brand' => 'Hyundai',
                'model' => 'Tucson',
                'license_plate' => 'B1222XYZ',
                'rental_rate' => 600000,
                'availability' => true,
            ],
            [
                'brand' => 'Kia',
                'model' => 'Sportage',
                'license_plate' => 'B3242XYZ',
                'rental_rate' => 550000,
                'availability' => true,
            ],
            [
                'brand' => 'Daihatsu',
                'model' => 'Terios',
                'license_plate' => 'B5262XYZ',
                'rental_rate' => 500000,
                'availability' => true,
            ],
        ]);
    }
}
