<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalSeeder extends Seeder
{
    public function run()
    {
        DB::table('rentals')->insert([
            [
                'user_id' => 1,
                'car_id' => 1,
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-05',
                'total_days' => 4,
                'total_cost' => 2000000,
                'status' => 'active',
            ],
            [
                'user_id' => 2,
                'car_id' => 2,
                'start_date' => '2024-10-06',
                'end_date' => '2024-10-10',
                'total_days' => 4,
                'total_cost' => 2400000,
                'status' => 'active',
            ],
            [
                'user_id' => 3,
                'car_id' => 3,
                'start_date' => '2024-10-11',
                'end_date' => '2024-10-15',
                'total_days' => 4,
                'total_cost' => 1800000,
                'status' => 'active',
            ],
            [
                'user_id' => 4,
                'car_id' => 4,
                'start_date' => '2024-10-16',
                'end_date' => '2024-10-20',
                'total_days' => 4,
                'total_cost' => 2200000,
                'status' => 'active',
            ],
            [
                'user_id' => 5,
                'car_id' => 5,
                'start_date' => '2024-10-21',
                'end_date' => '2024-10-25',
                'total_days' => 4,
                'total_cost' => 2800000,
                'status' => 'active',
            ],
            [
                'user_id' => 6,
                'car_id' => 6,
                'start_date' => '2024-10-26',
                'end_date' => '2024-10-30',
                'total_days' => 4,
                'total_cost' => 2600000,
                'status' => 'active',
            ],
        ]);
    }
}
