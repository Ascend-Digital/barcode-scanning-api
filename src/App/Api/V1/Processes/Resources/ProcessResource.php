<?php

namespace App\Api\V1\Processes\Resources;

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
        ];
    }
}
