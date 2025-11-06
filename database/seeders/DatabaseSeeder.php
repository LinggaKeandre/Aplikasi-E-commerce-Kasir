<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // create demo user
        $user = User::first() ?: User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
        ]);

        $cats = ['Makanan','Minuman','Perawatan','Ibu & Anak','Dapur'];
        foreach ($cats as $c) {
            $category = Category::create(['name' => $c, 'slug' => Str::slug($c)]);
            for ($i = 1; $i <= 8; $i++) {
                Product::create([
                    'category_id' => $category->id,
                    'title' => $c.' Produk '.$i,
                    'slug' => Str::slug($c.'-produk-'.$i.'-'.uniqid()),
                    'meta' => 'Meta '.$i,
                    'description' => 'Deskripsi '.$i,
                    'price' => rand(5000,200000),
                    'stock' => rand(0, 100),
                    'discount' => rand(0, 5) == 0 ? rand(10, 50) : null,
                    'brand' => 'Brand '.$i,
                    'image' => null,
                ]);
            }
        }

        // Seed reward vouchers
        $this->call([
            RewardVoucherSeeder::class,
        ]);
    }
}
