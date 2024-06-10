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
                'endpoint' => 'api.v1.barcodes.scan',
                'method' => 'POST',
                'owner_type' => 'item',
            ],
            [
                'title' => 'Place in storage location',
                'endpoint' => null,
                'method' => 'POST',
                'owner_type' => 'item',
            ],
            [
                'title' => 'Go to storage location',
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
                'endpoint' => null,
                'method' => 'POST',
                'owner_type' => 'process',
            ],
            [
                'title' => 'Login',
                'endpoint' => null,
                'method' => 'POST',
                'owner_type' => 'staff_member',
            ],
        ];

        DB::table('scannable_actions')->insert($actions);
    }
}
