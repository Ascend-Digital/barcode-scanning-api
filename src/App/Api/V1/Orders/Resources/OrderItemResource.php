<?php

namespace App\Api\V1\Orders\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'OrderItem',
            'id' => $this->id,
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
        ];
    }
}
