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
                'title' => 'Pick from storage location',
                'endpoint' => 'api.v1.storage-locations.items.pick',
                'method' => 'POST',
                'owner_type' => 'item',
            ],
            [
                'title' => 'Place in storage location',
                'endpoint' => 'api.v1.storage-locations.items.place',
                'method' => 'POST',
                'owner_type' => 'item',
            ],
            [
                'title' => 'Perform process',
                'endpoint' => 'api.v1.orders.items.processes',
                'method' => 'POST',
                'owner_type' => 'process',
            ],
        ];

        DB::table('scannable_actions')->insert($actions);
    }
}
