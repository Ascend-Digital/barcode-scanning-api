<?php

namespace Tests\Feature\Traits;

use Domain\Items\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Domain\Users\Models\StaffMember;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a barcode when a scannable model is created', function (Collection $scannableModels, $ownerType, $expectedCount) {
    $this->assertDatabaseCount('barcodes', $expectedCount);

    foreach ($scannableModels as $item) {
        $this->assertDatabaseHas('barcodes', [
            'company_id' => $item->company_id,
            'owner_type' => $ownerType,
            'owner_id' => $item->id,
        ]);
    }
})->with([
    [fn () => Item::factory(10)->create(), 'ownerType' => 'item', 'expectedCount' => 10],
    [fn () => Warehouse::factory(10)->create(), 'ownerType' => 'warehouse', 'expectedCount' => 10],
    [fn () => StorageLocation::factory(10)->create(), 'ownerType' => 'storage_location', 'expectedCount' => 20],
    [fn () => Workstation::factory(10)->create(), 'ownerType' => 'workstation', 'expectedCount' => 20],
    [fn () => Process::factory(10)->create(), 'ownerType' => 'process', 'expectedCount' => 10],
    [fn () => StaffMember::factory(10)->create(), 'ownerType' => 'staff_member', 'expectedCount' => 10],
    [fn () => Order::factory(10)->create(), 'ownerType' => 'order', 'expectedCount' => 10],
]);
