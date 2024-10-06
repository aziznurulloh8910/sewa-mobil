<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'address' => '123 Main St',
                'phone_number' => '1234567890',
                'driver_license' => 'D1234567',
                'role' => 0,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'address' => '456 Elm St',
                'phone_number' => '0987654321',
                'driver_license' => 'D7654321',
                'role' => 0,
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => Hash::make('password'),
                'address' => '789 Oak St',
                'phone_number' => '1122334455',
                'driver_license' => 'D1122334',
                'role' => 0,
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'address' => '321 Pine St',
                'phone_number' => '2233445566',
                'driver_license' => 'D2233445',
                'role' => 0,
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password'),
                'address' => '654 Maple St',
                'phone_number' => '3344556677',
                'driver_license' => 'D3344556',
                'role' => 0,
            ],
            [
                'name' => 'David Evans',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'address' => '987 Birch St',
                'phone_number' => '4455667788',
                'driver_license' => 'D4455667',
                'role' => 0,
            ],
            [
                'name' => 'Eve Foster',
                'email' => 'eve@example.com',
                'password' => Hash::make('password'),
                'address' => '123 Cedar St',
                'phone_number' => '5566778899',
                'driver_license' => 'D5566778',
                'role' => 0,
            ],
            [
                'name' => 'Frank Green',
                'email' => 'frank@example.com',
                'password' => Hash::make('password'),
                'address' => '456 Spruce St',
                'phone_number' => '6677889900',
                'driver_license' => 'D6677889',
                'role' => 0,
            ],
            [
                'name' => 'Grace Harris',
                'email' => 'grace@example.com',
                'password' => Hash::make('password'),
                'address' => '789 Willow St',
                'phone_number' => '7788990011',
                'driver_license' => 'D7788990',
                'role' => 0,
            ],
            [
                'name' => 'Hank Irving',
                'email' => 'hank@example.com',
                'password' => Hash::make('password'),
                'address' => '321 Aspen St',
                'phone_number' => '8899001122',
                'driver_license' => 'D8899001',
                'role' => 0,
            ],
            [
                'name' => 'Ivy Jackson',
                'email' => 'ivy@example.com',
                'password' => Hash::make('password'),
                'address' => '654 Redwood St',
                'phone_number' => '9900112233',
                'driver_license' => 'D9900112',
                'role' => 0,
            ],
        ]);
    }
}