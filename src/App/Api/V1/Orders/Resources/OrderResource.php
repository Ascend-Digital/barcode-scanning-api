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
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => $this->availableActions(),
        ];
    }

    private function availableActions(): array
    {
        return [
            [
                'name' => 'Pick from storage location',
                //                'endpoint' => route('storage-locations.item.pick')
            ],

        ];
    }
}
