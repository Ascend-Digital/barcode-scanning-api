<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            Warehouse::factory()
                ->hasWorkstations()
                ->hasStorageLocations()
                ->recycle($company)
                ->createQuietly();
        }
    }
}
