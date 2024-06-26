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
                'endpoint' => 'api.v1.storage-locations.order-items.pick',
                'method' => 'POST',
                'owner_type' => 'item',
                'expected_parameter_count' => 2,
                'key' => 'pickOrderItemFromStorageLocation',
            ],
            [
                'title' => 'Place order item in storage location',
                'endpoint' => 'api.v1.storage-locations.order-items.place',
                'method' => 'POST',
                'owner_type' => 'item',
                'expected_parameter_count' => 2,
                'key' => 'placeOrderItemInStorageLocation',

            ],
            [
                'title' => 'Place purchase order item in storage location',
                'endpoint' => 'api.v1.storage-locations.items.place',
                'method' => 'POST',
                'owner_type' => 'item',
                'expected_parameter_count' => 2,
                'key' => 'placeItemInStorageLocation',
            ],
            [
                'title' => 'Perform process',
                'endpoint' => 'api.v1.order-items.processes',
                'method' => 'POST',
                'owner_type' => 'process',
                'expected_parameter_count' => 2,
                'key' => 'performProcessOnOrderItem',
            ],
        ];

        DB::table('scannable_actions')->insert($actions);
    }
}
