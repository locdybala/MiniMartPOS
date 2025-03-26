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
            ['name' => 'Thực phẩm', 'description' => 'Tc', 'status' => 1, 'created_by' => 1],
            ['name' => 'Đồ uống', 'description' => 'Đối thủ của Coca-Cola', 'status' => 1, 'created_by' => 1],
            ['name' => 'Gia vị', 'description' => 'Đối thủ của Coca-Cola', 'status' => 1, 'created_by' => 1],
            ['name' => 'Hóa mỹ phẩm', 'description' => 'Đối thủ của Coca-Cola', 'status' => 1, 'created_by' => 1]
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
