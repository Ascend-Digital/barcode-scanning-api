<?php

namespace Tests\Feature\Api\V1\Barcodes;

use App\Api\V1\Items\Resources\ItemResource;
use App\Api\V1\Orders\Resources\OrderResource;
use App\Api\V1\Processes\Resources\ProcessResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;
use App\Api\V1\Users\Resources\StaffMemberResource;
use App\Api\V1\Warehouses\Resources\WarehouseResource;
use App\Api\V1\Warehouses\Resources\WorkstationResource;
use Domain\Items\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Domain\Users\Models\StaffMember;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

it('returns the correct resource when a barcode is scanned', function (Collection $scannedEntities, $type, $resource) {
    foreach ($scannedEntities as $scannedEntity) {
        $response = $this
            ->getJson(route('barcodes.scan', ['barcode' => $scannedEntity->barcode->barcode]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data.type', $type)
                ->where('data.company.id', $scannedEntity->company->id)
                ->where('data.company.name', $scannedEntity->company->name)
            );

        $this->assertJsonResponseContent($resource::make($scannedEntity), $response);
    }
})->with([
    [fn () => Item::factory(5)->create(), 'type' => 'Item', 'resource' => ItemResource::class],
    [fn () => Warehouse::factory(5)->create(), 'type' => 'Warehouse', 'resource' => WarehouseResource::class],
    [fn () => StorageLocation::factory(5)->create(), 'type' => 'StorageLocation', 'resource' => StorageLocationResource::class],
    [fn () => Workstation::factory(5)->create(), 'type' => 'Workstation', 'resource' => WorkstationResource::class],
    [fn () => Process::factory(5)->create(), 'type' => 'Process', 'resource' => ProcessResource::class],
    [fn () => StaffMember::factory(5)->create(), 'type' => 'StaffMember', 'resource' => StaffMemberResource::class],
    [fn () => Order::factory(5)->create(), 'type' => 'Order', 'resource' => OrderResource::class],
]);
