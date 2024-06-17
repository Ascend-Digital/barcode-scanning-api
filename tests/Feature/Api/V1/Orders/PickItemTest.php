<?php

use App\Api\V1\Items\Controllers\PickItemController;
use App\Api\V1\Items\Requests\PickItemRequest;
use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;

uses(RefreshDatabase::class);
uses(AdditionalAssertions::class);

it('picks an item', function () {
    Carbon::setTestNow(Carbon::parse('2024-06-12 12:00:00'));
    $currentQuantity = 20;
    $pickedQuantity = 2;
    $expectedTotal = $currentQuantity - $pickedQuantity;

    $item = Item::factory()->create();
    $storageLocation = StorageLocation::factory()->hasAttached(
        $item, ['quantity' => $currentQuantity]
    )->create();

    $this
        ->postJson(route('api.v1.storage-locations.items.pick', ['storageLocation' => $storageLocation, 'item' => $item, 'quantity' => $pickedQuantity]))
        ->assertOk();

    $this->assertDatabaseHas(
        'item_storage_location',
        [
            'item_id' => $item->id,
            'storage_location_id' => $storageLocation->id,
            'quantity' => $expectedTotal,
            'last_picked_at' => '2024-06-12 12:00:00',
            'last_placed_at' => null,
            'last_picked_quantity' => 2,
            'last_placed_quantity' => null,
        ]
    );
});

it('throws an exception if an attempt is made to pick more items than are available', function () {
    $currentQuantity = 1;
    $pickedQuantity = 2;
    $expectedTotal = $currentQuantity;

    $item = Item::factory()->create();
    $storageLocation = StorageLocation::factory()->hasAttached(
        $item, ['quantity' => $currentQuantity]
    )->create();

    $this
        ->postJson(route('api.v1.storage-locations.items.pick', ['storageLocation' => $storageLocation, 'item' => $item, 'quantity' => $pickedQuantity]))
        ->assertUnprocessable();

    $this->assertDatabaseHas(
        'item_storage_location',
        [
            'item_id' => $item->id,
            'storage_location_id' => $storageLocation->id,
            'quantity' => $expectedTotal,
            'last_picked_at' => null,
            'last_placed_at' => null,
            'last_picked_quantity' => null,
            'last_placed_quantity' => null,
        ]
    );
});

it('uses validation', function () {
    $this->assertActionUsesFormRequest(
        controller: PickItemController::class,
        method: '__invoke',
        form_request: PickItemRequest::class
    );
});
