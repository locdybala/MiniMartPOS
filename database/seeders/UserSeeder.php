<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role_id' => 1 // Admin
        ]);

        User::create([
            'name' => 'Nhân viên A',
            'email' => 'nhanvien1@gmail.com',
            'password' => Hash::make('123456'),
            'role_id' => 2 // Nhân viên
        ]);
    }
}
