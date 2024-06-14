<?php

namespace Database\Seeders;

use Domain\Orders\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::factory(200)->createQuietly();
    }
}
