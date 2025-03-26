<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Công ty A', 'email' => 'contact@companya.com', 'phone' => '0123456789', 'address' => 'Hà Nội'],
            ['name' => 'Công ty B', 'email' => 'contact@companyb.com', 'phone' => '0987654321', 'address' => 'TP. Hồ Chí Minh']
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
