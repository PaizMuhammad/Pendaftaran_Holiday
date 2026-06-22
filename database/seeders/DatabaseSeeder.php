<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UserSeeder agar akun 'admin' dibuat secara otomatis
        $this->call([
            UserSeeder::class,
        ]);
    }
}
