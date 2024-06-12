<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            StatusSeeder::class,
            WarehouseSeeder::class,
            BarcodeSeeder::class,
            ScannableActionSeeder::class,
        ]);

    }
}
