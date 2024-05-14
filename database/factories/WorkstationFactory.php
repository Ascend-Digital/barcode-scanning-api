<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Workstations\Models\Workstation>
 */
class WorkstationFactory extends Factory
{
    protected $model = Workstation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company_id' => Company::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
