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
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name', 100);
            $table->double('price', null, 0);
            $table->string('description', 400);
            $table->enum('origin', ['VN', 'CN', 'JP', 'US', 'TW', 'KR']);
            $table->string('category_id')->index('category_id');
            $table->string('brand_id')->index('brand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
