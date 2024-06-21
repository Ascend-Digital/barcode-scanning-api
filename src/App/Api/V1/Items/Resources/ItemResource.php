<?php

namespace App\Api\V1\Items\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;

class ItemResource extends ScannableResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Item',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'storage_locations' => StorageLocationResource::collection($this->whenLoaded('storageLocations')),
            'actions' => ScannableActionResource::collection($this->actions(
                [
                    'order' => $this->parameters['order_id'] ?? null,
                    'storageLocation' => $this->parameters['storage_location_id'] ?? null,
                    'item' => $this->id,
                ]
            )),
        ];
    }
}
