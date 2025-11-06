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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Shipping Address
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_province');
            $table->string('shipping_postal_code')->nullable();
            
            // Shipping Method
            $table->string('shipping_method'); // si_kere, si_hemat, etc
            $table->string('shipping_method_name'); // Si Kere, Si Hemat, etc
            $table->decimal('shipping_cost', 12, 2);
            $table->dateTime('estimated_delivery');
            
            // Payment
            $table->string('payment_method')->default('cod');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            
            // Pricing
            $table->decimal('subtotal', 12, 2); // Total harga produk setelah diskon
            $table->decimal('discount_amount', 12, 2)->default(0); // Total diskon produk
            $table->decimal('total', 12, 2); // Subtotal + shipping_cost - voucher_discount
            
            // Voucher
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->decimal('voucher_discount', 12, 2)->default(0);
            
            // Order Status
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            
            // Terms & Notes
            $table->boolean('terms_accepted')->default(false);
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
