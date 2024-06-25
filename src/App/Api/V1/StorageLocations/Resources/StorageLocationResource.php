<?php

namespace App\Api\V1\StorageLocations\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\Items\Resources\ItemResource;
use Domain\Orders\Models\OrderItem;
use Illuminate\Http\Request;

class StorageLocationResource extends ScannableResource
{
    public function toArray(Request $request): array
    {
//        dd($this->parameters);
        return [
            'id' => $this->id,
            'type' => 'StorageLocation',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'quantity' => $this->whenPivotLoaded('item_storage_location', function () {
                return $this->pivot->quantity;
            }),
            'actions' => isset($this->parameters['order_item_id']) ? $this->getActions($this->parameters['order_item_id']) : []
        ];
    }

    private function getActions($orderItemId)
    {
        $orderItem = OrderItem::find($orderItemId);

        if ($orderItem->status !== 'picked') {
            return [
                'title' => "Pick order item " . $orderItem->item->name . " from storage location",
                'endpoint' => route('api.v1.storage-locations.order-items.pick', ['storageLocation' => $this->id, 'orderItem' => $orderItemId])
            ];
        }

        return [
            'title' => 'Place in storage location',
            //'endpoint' => route('api.v1.storage-locations.order-items.pick', ['storageLocation' => $this->parameters['storage_location_id'], 'orderItem' => $this->id])
        ];
    }
}
