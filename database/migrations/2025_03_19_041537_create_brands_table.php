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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên thương hiệu
            $table->text('description')->nullable(); // Mô tả thương hiệu
            $table->boolean('status')->default(1); // Trạng thái: 1 = Hoạt động, 0 = Ngừng hoạt động
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Người tạo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
