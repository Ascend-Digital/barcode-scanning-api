<?php

namespace App\Api\V1\Orders\Resources;

use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Items\Resources\ItemResource;
use App\Api\V1\StorageLocations\Resources\StorageLocationResource;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'is_picked' => $this->status === 'picked',
            'storage_locations' => StorageLocationResource::collection($this->item->storageLocations->map(function (StorageLocation $item) {
                return new StorageLocationResource($item, ['status' => 'picked']);
            })),
            'actions' => []
        ];
    }
}
