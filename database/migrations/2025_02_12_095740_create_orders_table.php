<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users');
            $table->foreignId('address_id')->index()->constrained('addresses');
            $table->smallInteger('payment_status')
                ->default(\App\Enums\Order\PaymentStatusEnum::NOT_PAID);
            $table->decimal('cart_price');
            $table->decimal('total_price');
            $table->decimal('coupon')->nullable();
            $table->decimal('shipping')->nullable();
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
