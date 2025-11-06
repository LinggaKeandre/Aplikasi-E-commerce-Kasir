<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('verification_code', 2)->nullable()->after('voucher_discount');
            $table->boolean('is_verified')->default(false)->after('verification_code');
            $table->boolean('points_awarded')->default(false)->after('is_verified');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['verification_code', 'is_verified', 'points_awarded']);
        });
    }
};
