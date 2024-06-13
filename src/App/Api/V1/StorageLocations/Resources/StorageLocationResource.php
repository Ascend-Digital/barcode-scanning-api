<?php

namespace App\Api\V1\StorageLocations\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorageLocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'StorageLocation',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => ScannableActionResource::collection($this->actions()),
        ];
    }
}
