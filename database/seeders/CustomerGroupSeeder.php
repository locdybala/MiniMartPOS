<?php

namespace Database\Seeders;

use App\Models\CustomerGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        $groups = ['Thành viên mới', 'Khách hàng VIP', 'Khách hàng thân thiết'];

        foreach ($groups as $group) {
            CustomerGroup::create(['name' => $group]);
        }
    }
}
