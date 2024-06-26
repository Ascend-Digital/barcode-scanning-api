<?php

namespace App\Api\V1\Orders\Resources;

use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;
use Illuminate\Http\Request;

class OrderItemResource extends ScannableResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'OrderItem',
            'id' => $this->id,
            'name' => $this->item->name,
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'is_picked' => ! is_null($this->picked_at),
            'storage_locations' => StorageLocationResource::collection($this->item->storageLocations),
            'actions' => [],
        ];
    }
}
