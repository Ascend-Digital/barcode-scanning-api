<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $items = Item::all();

        foreach ($companies as $company) {
            Warehouse::factory()
                ->hasWorkstations()
                ->has(StorageLocation::factory()
                    ->hasAttached($items->where('company_id', $company->id)->random(25),
                        ['quantity' => rand(1, 400)])
                )
                ->recycle($company)
                ->createQuietly();
        }
    }
}
