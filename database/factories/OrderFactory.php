<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Order;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'status_id' => Status::factory(),
        ];
    }
}
