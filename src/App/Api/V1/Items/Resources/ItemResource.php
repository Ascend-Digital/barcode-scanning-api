<?php

namespace App\Api\V1\Items\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\Orders\Resources\OrderItemResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;
use Domain\Orders\Models\OrderItem;
use Domain\Warehouses\Models\StorageLocation;

class ItemResource extends ScannableResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Item',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'storage_locations' => StorageLocationResource::collection($this->storageLocations->map(function (StorageLocation $item) {
                return new StorageLocationResource($item, $this->parameters);
            })),
            'quantity' => $this->whenPivotLoaded('item_storage_location', function () {
                return $this->pivot->quantity;
            }),
        ];
    }
}
