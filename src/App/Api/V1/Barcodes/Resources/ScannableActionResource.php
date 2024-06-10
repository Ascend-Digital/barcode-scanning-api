<?php

namespace App\Api\V1\Barcodes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScannableActionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'endpoint' => $this->endpoint,
            'method' => $this->method,
        ];
    }
}
