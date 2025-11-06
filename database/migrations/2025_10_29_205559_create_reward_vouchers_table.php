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
        Schema::create('reward_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Gratis Ongkir Si Kere / Diskon Rp 25.000
            $table->string('shipping_method')->nullable(); // si_kere, si_hemat, dst (null untuk diskon harga)
            $table->string('shipping_method_name')->nullable(); // Display name (null untuk diskon harga)
            $table->integer('points_required'); // 50, 100, 160, dst
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_vouchers');
    }
};
