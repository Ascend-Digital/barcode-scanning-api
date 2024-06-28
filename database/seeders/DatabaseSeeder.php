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
            WarehouseSeeder::class,
            StatusSeeder::class,
            ProcessSeeder::class,
            OrderItemSeeder::class,
            BarcodeSeeder::class,
            ScannableActionSeeder::class,
        ]);
    }
}
