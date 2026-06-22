<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Holiday',
            'username' => 'admin',
            'email' => 'admin@holiday.com',
            'password' => Hash::make('adminholiday'),
            'role' => 'admin',
        ]);
    }
}
