<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Asset;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'role' => 1,
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'role' => 0,
        ]);

        Asset::factory()->count(20)->create();

        Criteria::factory()
            ->count(5)
            ->has(SubCriteria::factory()->count(4), 'subCriteria')
            ->create();

        // Criteria::factory()->count(5)->create();
    }
}
