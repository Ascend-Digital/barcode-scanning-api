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
            'actions' => ScannableActionResource::collection($this->actions(
                [
                    // TODO read this from either the db or have it passed through/read on the client
                    'order' => 1,
                    // TODO read this from either the db or have it passed through/read on the client
                    'item' => 1,
                    'process' => $this->id,
                ]
            )),
        ];
    }
}
