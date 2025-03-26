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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên nhà cung cấp
            $table->string('email')->unique()->nullable(); // Email liên hệ
            $table->string('phone')->nullable(); // Số điện thoại liên hệ
            $table->string('address')->nullable(); // Địa chỉ
            $table->text('description')->nullable(); // Mô tả thương hiệu
            $table->string('taxcode')->nullable(); // Số điện thoại liên hệ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
