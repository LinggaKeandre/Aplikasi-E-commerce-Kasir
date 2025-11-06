<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Kasir',
            'email' => 'admin@kasir.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
            'phone' => '081234567891',
            'address' => 'Jl. Kasir No. 2',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
        ]);

        // Member untuk testing
        User::create([
            'name' => 'Member Test',
            'email' => 'member@kasir.com',
            'password' => Hash::make('member123'),
            'role' => 'member',
            'phone' => '081234567892',
            'address' => 'Jl. Member No. 3',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
        ]);
    }
}

