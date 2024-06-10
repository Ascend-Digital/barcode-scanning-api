<?php

namespace App\Api\V1\Processes\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Process',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            // TODO this will be updated when the perform process endpoint is done
            'actions' => ScannableActionResource::collection($this->actions(
                [
                    'barcode' => $this->id,
                ]
            )),
        ];
    }
}
