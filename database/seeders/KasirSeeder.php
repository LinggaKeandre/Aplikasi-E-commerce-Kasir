<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kasir Utama',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);
    }
}
