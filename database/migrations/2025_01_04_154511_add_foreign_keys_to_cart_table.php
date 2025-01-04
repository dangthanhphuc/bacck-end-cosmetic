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
        Schema::table('cart', function (Blueprint $table) {
            $table->foreign(['product_id'], 'cart_ibfk_1')->references(['id'])->on('products')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'cart_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropForeign('cart_ibfk_1');
            $table->dropForeign('cart_ibfk_2');
        });
    }
};
