<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Coca-Cola', 'description' => 'Nước ngọt có gas', 'status' => 1, 'created_by' => 1],
            ['name' => 'Pepsi', 'description' => 'Đối thủ của Coca-Cola', 'status' => 1, 'created_by' => 1]
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
