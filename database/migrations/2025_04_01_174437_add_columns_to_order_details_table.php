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
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('product_name'); // Lưu tên sản phẩm, phòng trường hợp sản phẩm bị xóa
            $table->string('product_image')->nullable(); // Lưu ảnh sản phẩm để hiển thị dễ hơn
            $table->decimal('subtotal', 10, 2)->default(0); // Tổng tiền của từng sản phẩm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'product_image', 'subtotal']);
        });
    }
};
