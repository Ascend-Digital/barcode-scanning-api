<?php

namespace Tests\Feature\Api\V1\Barcodes;

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
use Domain\Processes\Models\Process;
use Domain\Users\Models\StaffMember;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

it('returns the correct resource when a barcode is scanned', function (Collection $scannedEntities, $resource) {
    foreach ($scannedEntities as $scannedEntity) {
        $type = str_replace('Resource', '', last(explode('\\', $resource)));

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
    [fn () => Item::factory(5)->create(), 'resource' => ItemResource::class],
    [fn () => Warehouse::factory(5)->create(), 'resource' => WarehouseResource::class],
    [fn () => StorageLocation::factory(5)->create(), 'resource' => StorageLocationResource::class],
    [fn () => Workstation::factory(5)->create(), 'resource' => WorkstationResource::class],
    [fn () => Process::factory(5)->create(), 'resource' => ProcessResource::class],
    [fn () => StaffMember::factory(5)->create(), 'resource' => StaffMemberResource::class],
    [fn () => Order::factory(5)->create(), 'resource' => OrderResource::class],
]);

// TODO Amend this when more endpoints have been added to the repo, and use factories
it('returns the correct actions when a barcode is scanned, skipping any where the url has failed to generate', function () {
    $scannableAction = ScannableAction::factory([
        'owner_type' => 'process',
        'endpoint' => 'api.v1.barcodes.scan',
    ])->create();

    ScannableAction::factory([
        'owner_type' => 'process',
        'endpoint' => 'i-do-not-exist',
    ])->create();

    $process = Process::factory()->create();

    $expectedActionCollection = [
        [
            'title' => $scannableAction->title,
            'endpoint' => route('api.v1.barcodes.scan', ['barcode' => $process->id]),
            'method' => $scannableAction->method,
        ],
    ];

    $this
        ->getJson(route('api.v1.barcodes.scan', ['barcode' => $process->barcode->barcode]))
        ->assertOk()
        ->assertJsonPath('data.actions', $expectedActionCollection);
});
