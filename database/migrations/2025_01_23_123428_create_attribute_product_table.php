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
        Schema::create('attribute_product', function (Blueprint $table) {
            $table->foreignId('product_id')->index()->constrained('products');
            $table->foreignId('attribute_id')->index()->constrained('attributes');
            $table->primary(['product_id', 'attribute_id']);
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_product');
    }
};
