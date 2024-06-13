<?php

namespace Database\Factories;

use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::exists() ? Order::inRandomOrder()->first() : Order::factory(),
            'item_id' => Item::exists() ? Item::inRandomOrder()->first() : Item::factory(),
        ];
    }
}
