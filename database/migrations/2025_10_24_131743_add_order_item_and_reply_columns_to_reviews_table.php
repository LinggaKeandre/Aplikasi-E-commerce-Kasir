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
        Schema::table('reviews', function (Blueprint $table) {
            // Rename comment to review
            $table->renameColumn('comment', 'review');
            
            // Add new columns
            $table->foreignId('order_item_id')->nullable()->after('id')->constrained('order_items')->onDelete('cascade');
            $table->text('admin_reply')->nullable()->after('review');
            $table->foreignId('replied_by')->nullable()->after('admin_reply')->constrained('users')->onDelete('set null');
            $table->timestamp('replied_at')->nullable()->after('replied_by');
            
            // Add unique constraint
            $table->unique('order_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->dropForeign(['replied_by']);
            $table->dropUnique(['order_item_id']);
            $table->dropColumn(['order_item_id', 'admin_reply', 'replied_by', 'replied_at']);
            $table->renameColumn('review', 'comment');
        });
    }
};
