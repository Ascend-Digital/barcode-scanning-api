<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ScannableActionSeeder extends Seeder
{
    public function run(): void
    {
        $actions = [
            [
                'title' => 'Pick order item from storage location',
                'endpoint' => 'api.v1.orders.storage-locations.items.pick',
                'method' => 'POST',
                'owner_type' => 'item',
                'expected_parameter_count' => 3,
            ],
            [
                'title' => 'Place order item in storage location',
                'endpoint' => 'api.v1.orders.storage-locations.items.place',
                'method' => 'POST',
                'owner_type' => 'item',
                'expected_parameter_count' => 3,
            ],
            [
                'title' => 'Place purchase order item in storage location',
                'endpoint' => 'api.v1.storage-locations.items.place',
                'method' => 'POST',
                'owner_type' => 'item',
                'expected_parameter_count' => 2,
            ],
            [
                'title' => 'Perform process',
                'endpoint' => 'api.v1.order-items.processes',
                'method' => 'POST',
                'owner_type' => 'process',
                'expected_parameter_count' => 2,
            ],
        ];

        DB::table('scannable_actions')->insert($actions);
    }
}
