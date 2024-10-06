<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CarSeeder;
use Database\Seeders\RentalSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(RentalSeeder::class);

        // $this->call(AssetSeeder::class);

        // \App\Models\Asset::factory(10)->create();
    }
}
