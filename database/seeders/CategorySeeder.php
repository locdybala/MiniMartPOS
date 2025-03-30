<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Thế giới mỳ ăn liền', 'description' => 'Tc', 'status' => 1, 'created_by' => 1],
            ['name' => 'Gia Vị Dầu Ăn', 'description' => 'Đối thủ của Coca-Cola', 'status' => 1, 'created_by' => 1],
            ['name' => 'Bánh Kẹo', 'description' => 'Đối thủ của Coca-Cola', 'status' => 1, 'created_by' => 1],
            ['name' => 'Giải Khát', 'description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Đồ Dùng Nhà Bếp', 'description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Tắm Gội Xả', 'description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Tương Mắm', 'description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Điện gia dụng', 'description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Sản phẩm từ sữa', 'description' => null, 'status' => 1, 'created_by' => 1],
            ['name' => 'Trà Cafe', 'description' => null, 'status' => 1, 'created_by' => 1],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
