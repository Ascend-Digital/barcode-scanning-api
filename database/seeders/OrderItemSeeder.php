<?php

namespace Database\Seeders;

use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            OrderItem::factory(20)->for($order)->create();
        }
    }
}
