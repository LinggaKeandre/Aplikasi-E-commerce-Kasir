<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            // Voucher Gratis Ongkir
            [
                'name' => 'Gratis Ongkir Si Kere',
                'type' => 'free_shipping',
                'shipping_method' => 'si_kere',
                'shipping_method_name' => 'Si Kere',
                'discount_amount' => 0,
                'points_required' => 50,
                'description' => 'Voucher gratis ongkir untuk metode pengiriman Si Kere',
                'is_active' => true,
            ],
            [
                'name' => 'Gratis Ongkir Si Hemat',
                'type' => 'free_shipping',
                'shipping_method' => 'si_hemat',
                'shipping_method_name' => 'Si Hemat',
                'discount_amount' => 0,
                'points_required' => 100,
                'description' => 'Voucher gratis ongkir untuk metode pengiriman Si Hemat',
                'is_active' => true,
            ],
            [
                'name' => 'Gratis Ongkir Si Normal',
                'type' => 'free_shipping',
                'shipping_method' => 'si_normal',
                'shipping_method_name' => 'Si Normal',
                'discount_amount' => 0,
                'points_required' => 160,
                'description' => 'Voucher gratis ongkir untuk metode pengiriman Si Normal',
                'is_active' => true,
            ],
            [
                'name' => 'Gratis Ongkir Sahabat Kasir',
                'type' => 'free_shipping',
                'shipping_method' => 'sahabat_kasir',
                'shipping_method_name' => 'Sahabat Kasir',
                'discount_amount' => 0,
                'points_required' => 240,
                'description' => 'Voucher gratis ongkir untuk metode pengiriman Sahabat Kasir',
                'is_active' => true,
            ],
            [
                'name' => 'Gratis Ongkir Si Sultan',
                'type' => 'free_shipping',
                'shipping_method' => 'si_sultan',
                'shipping_method_name' => 'Si Sultan',
                'discount_amount' => 0,
                'points_required' => 320,
                'description' => 'Voucher gratis ongkir untuk metode pengiriman Si Sultan',
                'is_active' => true,
            ],
            [
                'name' => 'Gratis Ongkir Crazy Rich',
                'type' => 'free_shipping',
                'shipping_method' => 'crazy_rich',
                'shipping_method_name' => 'Crazy Rich',
                'discount_amount' => 0,
                'points_required' => 400,
                'description' => 'Voucher gratis ongkir untuk metode pengiriman Crazy Rich',
                'is_active' => true,
            ],
            
            // Voucher Diskon Harga
            [
                'name' => 'Diskon Rp 25.000',
                'type' => 'price_discount',
                'shipping_method' => null,
                'shipping_method_name' => null,
                'discount_amount' => 25000,
                'points_required' => 800,
                'description' => 'Potongan harga Rp 25.000 untuk total belanja',
                'is_active' => true,
            ],
            [
                'name' => 'Diskon Rp 50.000',
                'type' => 'price_discount',
                'shipping_method' => null,
                'shipping_method_name' => null,
                'discount_amount' => 50000,
                'points_required' => 1500,
                'description' => 'Potongan harga Rp 50.000 untuk total belanja',
                'is_active' => true,
            ],
            [
                'name' => 'Diskon Rp 100.000',
                'type' => 'price_discount',
                'shipping_method' => null,
                'shipping_method_name' => null,
                'discount_amount' => 100000,
                'points_required' => 2800,
                'description' => 'Potongan harga Rp 100.000 untuk total belanja',
                'is_active' => true,
            ],
        ];

        foreach ($vouchers as $voucher) {
            DB::table('reward_vouchers')->insert(array_merge($voucher, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
