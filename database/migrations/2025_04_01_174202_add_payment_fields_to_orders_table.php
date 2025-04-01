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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cod', 'vnpay', 'momo', 'paypal'])->default('cod');
            $table->string('payment_status')->default('unpaid');
            $table->string('transaction_id')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_fee', 10, 2)->default(20000);
            $table->decimal('final_total', 10, 2)->default(0);
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('customer_address');
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'transaction_id', 'discount_amount',
                'shipping_fee', 'final_total','customer_name', 'customer_phone', 'customer_email', 'customer_address', 'note']);
        });
    }
};
