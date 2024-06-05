<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkstationFactory extends Factory
{
    protected $model = Workstation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company_id' => Company::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
