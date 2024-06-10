<?php

namespace App\Api\V1\Orders\Resources;

use App\Api\V1\Companies\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Order',
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => $this->availableActions(),
        ];
    }
}
