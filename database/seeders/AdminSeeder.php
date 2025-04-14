<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'phoibe@gmail.com'],
            [
                'name' => 'Phoibe Admin',
                'password' => Hash::make('phoibe@123'),
            ]
        );
    }
}
