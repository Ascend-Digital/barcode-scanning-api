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
            'storage_locations' => StorageLocationResource::collection($this->item->storageLocations),
            'actions' => isset($this->parameters['storage_location_id']) ? $this->getActions($this) : []
        ];
    }

    private function getActions($orderItem)
    {
        if ($this->parameters['storage_location_id']) {
            if ($orderItem->status !== 'picked') {
                return [
                    'title' => 'Pick from storage location',
                    'endpoint' => route('api.v1.storage-locations.order-items.pick', ['storageLocation' => $this->parameters['storage_location_id'], 'orderItem' => $this->id])
                ];
            }

            return [
                'title' => 'Place in storage location',
                //'endpoint' => route('api.v1.storage-locations.order-items.pick', ['storageLocation' => $this->parameters['storage_location_id'], 'orderItem' => $this->id])
            ];
        }
    }
}
