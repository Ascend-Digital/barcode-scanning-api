<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StorageLocationFactory extends Factory
{
    protected $model = StorageLocation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company_id' => Company::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
