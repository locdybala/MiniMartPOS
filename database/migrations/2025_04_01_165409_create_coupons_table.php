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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name');
            $table->integer('coupon_time');
            $table->tinyInteger('coupon_condition'); // 1: Giảm theo %; 2: Giảm theo tiền
            $table->decimal('coupon_number', 10, 0); // Giá trị giảm
            $table->string('coupon_code');
            $table->date('coupon_date_start');
            $table->date('coupon_date_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
