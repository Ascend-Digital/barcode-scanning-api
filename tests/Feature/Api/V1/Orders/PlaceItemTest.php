<?php

use App\Api\V1\Items\Controllers\PlaceItemController;
use App\Api\V1\Items\Requests\PlaceItemRequest;
use App\Api\V1\Orders\Resources\OrderItemResource;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;

uses(RefreshDatabase::class);
uses(AdditionalAssertions::class);

it('updates an item quantity correctly', function () {
    Carbon::setTestNow(Carbon::parse('2024-06-12 12:00:00'));
    $currentQuantity = 3;
    $addedQuantity = 2;
    $expectedTotal = $currentQuantity + $addedQuantity;

    $item = Item::factory()->create();
    $order = Order::factory()->create();

    $storageLocation = StorageLocation::factory()->hasAttached(
        $item, ['quantity' => $currentQuantity]
    )->create();

    $orderItem = OrderItem::factory([
        'order_id' => $order->id,
        'item_id' => $item->id,
    ])->create();

    $response = $this
        ->postJson(route('api.v1.orders.storage-locations.items.place', ['order' => $order, 'storageLocation' => $storageLocation, 'item' => $item, 'quantity' => $addedQuantity]))
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.type', 'OrderItem')
            ->where('data.order_id', $orderItem->order_id)
            ->where('data.item_id', $orderItem->item_id)
        );

    $this->assertJsonResponseContent(OrderItemResource::make($orderItem), $response);

    $this->assertDatabaseHas(
        'item_storage_location',
        [
            'item_id' => $item->id,
            'storage_location_id' => $storageLocation->id,
            'quantity' => $expectedTotal,
            'last_picked_at' => null,
            'last_placed_at' => '2024-06-12 12:00:00',
            'last_picked_quantity' => null,
            'last_placed_quantity' => $addedQuantity,
        ]
    );
});

it('places an item which does not already exist in a storage location', function () {
    Carbon::setTestNow(Carbon::parse('2024-06-12 12:00:00'));

    $addedQuantity = 2;
    $expectedTotal = $addedQuantity;

    $item = Item::factory()->create();
    $order = Order::factory()->create();
    $storageLocation = StorageLocation::factory()->create();

    $orderItem = OrderItem::factory([
        'order_id' => $order->id,
        'item_id' => $item->id,
    ])->create();

    $response = $this
        ->postJson(route('api.v1.orders.storage-locations.items.place', ['order' => $order, 'storageLocation' => $storageLocation, 'item' => $item, 'quantity' => $addedQuantity]))
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.type', 'OrderItem')
            ->where('data.order_id', $orderItem->order_id)
            ->where('data.item_id', $orderItem->item_id)
        );

    $this->assertJsonResponseContent(OrderItemResource::make($orderItem), $response);

    $this->assertDatabaseHas(
        'item_storage_location',
        [
            'item_id' => $item->id,
            'storage_location_id' => $storageLocation->id,
            'quantity' => $expectedTotal,
            'last_picked_at' => null,
            'last_placed_at' => '2024-06-12 12:00:00',
            'last_picked_quantity' => null,
            'last_placed_quantity' => $addedQuantity,
        ]
    );
});

it('throws an exception if an item cannot be placed in a storage location')->todo();

it('uses validation', function () {
    $this->assertActionUsesFormRequest(
        controller: PlaceItemController::class,
        method: '__invoke',
        form_request: PlaceItemRequest::class
    );
});
