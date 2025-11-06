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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->string('product_name'); // Snapshot nama produk
            $table->decimal('product_price', 12, 2); // Harga asli
            $table->integer('product_discount')->default(0); // Diskon persen
            $table->decimal('final_price', 12, 2); // Harga setelah diskon
            
            $table->integer('quantity');
            $table->string('variant_size')->nullable();
            $table->string('variant_color')->nullable();
            
            $table->decimal('subtotal', 12, 2); // final_price * quantity
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
