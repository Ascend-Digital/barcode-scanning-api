<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company_id' => Company::factory(),
        ];
    }
}
