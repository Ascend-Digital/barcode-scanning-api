<?php

namespace App\Api\V1\Items\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
                // TODO Remove commented-out code which illustrates how this will work when endpoints are added
                /*
                [
                    'order' =>
                    'workstation' =>

                ]
                */
            )),
        ];
    }
}
