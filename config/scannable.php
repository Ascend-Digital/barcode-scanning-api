<?php

use Domain\Items\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Domain\Users\Models\StaffMember;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;

return [
    'models' => [
        Warehouse::class,
        Item::class,
        StorageLocation::class,
        Workstation::class,
        Process::class,
        StaffMember::class,
        Order::class,
    ],
    'actions' => [
        Item::class => [
            [
                'name' => 'Pick from storage location',
                'endpoint' => 'storage-locations.item.pick',
                'method' => 'POST',
                'bind_id' => true,
            ],
            [
                'name' => 'Place in storage location',
                'endpoint' => 'storage-locations.item.place',
                'method' => 'POST',
                'bind_id' => true,
            ],
        ],
        Order::class => [
            [
                'name' => 'Go to storage location',
                'endpoint' => null,
                'bind_id' => false,
            ],
        ],
        Warehouse::class => [
            [
                'name' => 'Go to next screen',
                'endpoint' => null,
                'bind_id' => false,

            ],
        ],
        StorageLocation::class => [
        ],
        Workstation::class => [
            [
                'name' => 'Open camera to scan process',
                'endpoint' => null,
                'bind_id' => false,

            ],
        ],
        Process::class => [
            [
                'name' => 'Perform process',
                'endpoint' => 'processes.perform',
                'bind_id' => true,
            ],
        ],
        StaffMember::class => [
            [
                'name' => 'Login',
                'endpoint' => 'login',
                'bind_id' => false,
                'method' => 'POST',
            ],
        ],
    ],
];
