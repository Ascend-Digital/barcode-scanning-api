<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
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
                ->has(Workstation::factory())
                ->has(StorageLocation::factory())
                ->recycle($company)
                ->create();
        }
    }
}
