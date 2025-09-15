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
            $table->id('product_id');
            $table->string('sku')->unique();
            $table->string('description');
            $table->string('size');
            $table->string('photo');
            $table->jsonb('tags');
            $table->date('updated_at');

            $table->index(['sku']);
        });

        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id('stock_id');
            $table->string('sku');
            $table->integer('stock');
            $table->string('city');

            $table->unique(['sku', 'city']);
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
