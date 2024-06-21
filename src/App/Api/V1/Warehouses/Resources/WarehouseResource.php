<?php

namespace App\Api\V1\Warehouses\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;

class WarehouseResource extends ScannableResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Warehouse',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => ScannableActionResource::collection($this->actions()),
        ];
    }
}
