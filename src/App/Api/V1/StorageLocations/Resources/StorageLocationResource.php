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
        return [
            'id' => $this->id,
            'type' => 'StorageLocation',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'quantity' => $this->whenPivotLoaded('item_storage_location', function () {
                return $this->pivot->quantity;
            }),
            'actions' => ScannableActionResource::collection(
                $this->actions(
                    [
                        'orderItem' => $this->parameters['order_item_id'] ?? null,
                        'storageLocation' => $this->id,
                    ],
                    $this->getKey($this->parameters)
                )
            ),
        ];
    }

    private function getKey($parameters)
    {
        if (! isset($parameters['order_item_id'])) {
            return [];
        }

        $orderItem = OrderItem::find($parameters['order_item_id']);

        return ! is_null($orderItem->picked_at) ? 'placeItemInStorageLocation' : 'pickItemFromStorageLocation';
    }
}
