<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'phone' => '0123456789',
            'password' => Hash::make('123456'),
            'customer_group_id' => 1,
        ]);
    }
}
