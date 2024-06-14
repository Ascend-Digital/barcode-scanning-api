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
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'item',
            ],
            [
                'title' => 'Place in storage location',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'item',
            ],
            [
                'title' => 'Scan a process',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'item',
            ],
            [
                'title' => 'This is a warehouse action',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'warehouse',
            ],
            [
                'title' => 'A warehouse action',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'warehouse',
            ],
            [
                'title' => 'Go to storage location',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'order',
            ],
            [
                'title' => 'An order action',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'order',
            ],
            [
                'title' => 'Open camera to scan process',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'workstation',
            ],
            [
                'title' => 'Perform process',
                'endpoint' => 'api.v1.orders.items.processes',
                'method' => 'POST',
                'owner_type' => 'process',
            ],
            [
                'title' => 'A process action',
                'endpoint' => null,
                'method' => 'POST',
                'owner_type' => 'process',
            ],
            [
                'title' => 'Scan an item',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'storage_location',
            ],
            [
                'title' => 'A storage location action',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'storage_location',
            ],
            [
                'title' => 'Login',
                'endpoint' => null,
                'method' => null,
                'owner_type' => 'staff_member',
            ],
        ];

        DB::table('scannable_actions')->insert($actions);
    }
}
