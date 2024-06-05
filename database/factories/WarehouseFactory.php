<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company_id' => Company::factory(),
        ];
    }
}
