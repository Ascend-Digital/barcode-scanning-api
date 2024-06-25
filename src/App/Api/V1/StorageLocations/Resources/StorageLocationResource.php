<?php

namespace App\Api\V1\StorageLocations\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\Items\Resources\ItemResource;
use App\Shared\Urls\UrlGenerator;
use Domain\Barcodes\Models\ScannableAction;
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
                    ]
                ))
        ];
    }

    private function actions($parameters = null)
    {
        if (! isset($parameters['orderItem'])) {
            return [];
        }

        $orderItemId = $parameters['orderItem'];
        $orderItem = OrderItem::find($orderItemId);

        $key = $orderItem->status === 'picked' ? 'placeItemInStorageLocation' : 'pickItemFromStorageLocation';

        return ScannableAction::where('owner_type', 'storage_location')
            ->where('key', $key)
            ->get()
            ->map(function (ScannableAction $action) use ($parameters) {
                if ($action->endpoint !== null) {
                    $action->endpoint = UrlGenerator::generateActionUrl($action, $parameters);
                }

                return $action;
            })->reject(function (ScannableAction $action) {
                return $action->method !== null && $action->endpoint === null;
            });
    }
}
