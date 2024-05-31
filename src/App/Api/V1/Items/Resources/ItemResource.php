<?php

namespace App\Api\V1\Items\Resources;

use App\Api\V1\Companies\Resources\CompanyResource;
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
            'actions' => $this->availableActions(), // use a resource
        ];
    }
}
