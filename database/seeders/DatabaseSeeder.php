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
        // Akun admin dibuat secara eksplisit melalui `php artisan admin:create`.
        $this->call(SalesProfileSeeder::class);
    }
}
