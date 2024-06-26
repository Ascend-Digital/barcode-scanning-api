<?php

namespace Tests\Feature\Api\V1\Barcodes;

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Api\V1\Barcodes\Requests\ScanBarcodeRequest;
use App\Api\V1\Items\Resources\ItemResource;
use App\Api\V1\Orders\Resources\OrderResource;
use App\Api\V1\Processes\Resources\ProcessResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;
use App\Api\V1\Users\Resources\StaffMemberResource;
use App\Api\V1\Warehouses\Resources\WarehouseResource;
use App\Api\V1\Warehouses\Resources\WorkstationResource;
use Domain\Barcodes\Models\ScannableAction;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;
use Domain\Users\Models\StaffMember;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;

uses(RefreshDatabase::class);
uses(AdditionalAssertions::class);

it('returns the correct resource when a barcode is scanned', function (Collection $scannedEntities, $resource, $relationshipsToLoad) {
    foreach ($scannedEntities as $scannedEntity) {
        $type = str_replace('Resource', '', last(explode('\\', $resource)));

        if ($relationshipsToLoad) {
            $scannedEntity->loadMissing($relationshipsToLoad);
        }

        $response = $this
            ->getJson(route('api.v1.barcodes.scan', ['barcode' => $scannedEntity->barcode->barcode]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data.type', $type)
                ->where('data.company.id', $scannedEntity->company->id)
                ->where('data.company.name', $scannedEntity->company->name)
            );

        $this->assertJsonResponseContent($resource::make($scannedEntity), $response);
    }
})->with([
    [fn () => Item::factory(5)->create(), 'resource' => ItemResource::class, 'relationshipsToLoad' => 'storageLocations'],
    [fn () => Warehouse::factory(5)->create(), 'resource' => WarehouseResource::class, 'relationshipsToLoad' => ''],
    [fn () => StorageLocation::factory(5)->create(), 'resource' => StorageLocationResource::class, 'relationshipsToLoad' => 'items'],
    [fn () => Workstation::factory(5)->create(), 'resource' => WorkstationResource::class, 'relationshipsToLoad' => ''],
    [fn () => Process::factory(5)->create(), 'resource' => ProcessResource::class, 'relationshipsToLoad' => ''],
    [fn () => StaffMember::factory(5)->create(), 'resource' => StaffMemberResource::class, 'relationshipsToLoad' => ''],
    [fn () => Order::factory(5)->create(), 'resource' => OrderResource::class, 'relationshipsToLoad' => 'orderItems'],
]);

it('returns item quantities when a storage location or item is scanned, and the data is available', function (Item|StorageLocation $model, string $property) {
    $quantity = 10;

    $this
        ->getJson(route('api.v1.barcodes.scan', ['barcode' => $model->barcode->barcode]))
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where($property, $quantity)
        );
})->with([
    [fn () => Item::factory()->hasAttached(StorageLocation::factory(), ['quantity' => 10])->create(), 'property' => 'data.storage_locations.0.quantity'],
    [fn () => StorageLocation::factory()->hasAttached(Item::factory(), ['quantity' => 10])->create(), 'property' => 'data.items.0.quantity'],
]);

it('returns correct quantities when multiple items exist in several storage locations')->todo();

// TODO Amend this when more endpoints have been added to the repo
it('returns the correct actions when a barcode is scanned, skipping any where the url has failed to generate', function () {
    $scannableAction = ScannableAction::factory([
        'owner_type' => 'process',
        'endpoint' => 'api.v1.order-items.processes',
        'method' => 'POST',
        'expected_parameter_count' => 2,
        'key' => 'performProcessOnOrderItem',
    ])->create();

    ScannableAction::factory([
        'owner_type' => 'process',
        'endpoint' => 'i-do-not-exist',
        'key' => 'key-2',
    ])->create();

    $process = Process::factory()->create();
    $order = Order::factory()->create();
    $item = Item::factory()->create();

    $orderItem = OrderItem::factory([
        'order_id' => $order->id,
        'item_id' => $item->id,
    ])->create();

    $expectedActionCollection = [
        [
            'title' => $scannableAction->title,
            'endpoint' => route('api.v1.order-items.processes',
                [
                    'orderItem' => $orderItem->id,
                    'process' => $process->id,
                ], false),
            'method' => $scannableAction->method,
        ],
    ];

    $this
        ->getJson(route('api.v1.barcodes.scan', [
            'barcode' => $process->barcode->barcode,
            'order_item_id' => $orderItem->id,
        ]))
        ->assertOk()
        ->assertJsonPath('data.actions', $expectedActionCollection);
});

it('returns the correct actions for picking and placing, depending on whether an order item has already been picked or placed')->todo();

it('uses validation', function () {
    $this->assertActionUsesFormRequest(
        controller: ScanBarcodeController::class,
        method: '__invoke',
        form_request: ScanBarcodeRequest::class
    );
});
