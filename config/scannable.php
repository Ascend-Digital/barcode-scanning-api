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
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
        Order::class => [
            [
                'name' => 'Pick from storage location',
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
        Warehouse::class => [
            [
                'name' => 'Go to next screen',
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
        StorageLocation::class => [
            [
                'name' => 'Pick from storage location',
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
        Workstation::class => [
            [
                'name' => 'Pick from storage location',
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
        Process::class => [
            [
                'name' => 'Pick from storage location',
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
        StaffMember::class => [
            [
                'name' => 'Pick from storage location',
                //'endpoint' => route('storage-locations.item.pick')
            ],
            [
                'name' => 'Place in storage location',
                //'endpoint' => route('storage-locations.item.place')
            ],
        ],
    ],
];
