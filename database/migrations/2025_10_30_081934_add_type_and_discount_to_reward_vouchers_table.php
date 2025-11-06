<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reward_vouchers', function (Blueprint $table) {
            $table->enum('type', ['free_shipping', 'price_discount'])->default('free_shipping')->after('name');
            $table->decimal('discount_amount', 10, 0)->default(0)->after('shipping_method_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reward_vouchers', function (Blueprint $table) {
            $table->dropColumn(['type', 'discount_amount']);
        });
    }
};
