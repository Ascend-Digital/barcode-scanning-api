<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Order;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'status_id' => Status::factory(),
        ];
    }
}
