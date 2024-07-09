<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CriteriaSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AssetSeeder;
use Database\Seeders\EvaluationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $this->call(AssetSeeder::class);

        $this->call(CriteriaSeeder::class);
        
        $this->call(EvaluationSeeder::class);
    }
}