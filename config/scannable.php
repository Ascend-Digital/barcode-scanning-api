<?php

use Domain\Items\Models\Item;
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
    ],
];
