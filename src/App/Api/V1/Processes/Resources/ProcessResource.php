<?php

namespace App\Api\V1\Processes\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use Illuminate\Http\Request;

class ProcessResource extends ScannableResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Process',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => ScannableActionResource::collection($this->actions(
                [
                    'orderItem' => $this->parameters['order_item_id'] ?? null,
                    'process' => $this->id,
                ]
            )),
        ];
    }
}
