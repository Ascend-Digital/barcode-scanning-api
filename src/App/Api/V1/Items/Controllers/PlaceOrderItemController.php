<?php

namespace App\Api\V1\Items\Controllers;

use App\Api\V1\Items\Requests\PlaceItemRequest;
use App\Api\V1\Orders\Resources\OrderItemResource;
use Domain\Orders\Actions\AddItemToStorageLocation;
use Domain\Orders\Actions\UpdateItemQuantity;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Warehouses\Models\StorageLocation;

class PlaceOrderItemController
{
    public function __invoke(
        PlaceItemRequest $placeItemRequest,
        AddItemToStorageLocation $addItemToStorageLocation,
        UpdateItemQuantity $updateItemQuantity,
        StorageLocation $storageLocation,
        OrderItem $orderItem): OrderItemResource
    {
        $quantity = $placeItemRequest->validated('quantity');
        $item = $orderItem->item;

        $itemInStorage = $storageLocation->items()->find($item->id);

        // TODO use DTOs
        if (! $itemInStorage) {
            $addItemToStorageLocation->execute($quantity, $storageLocation, $item);
        } else {
            $updateItemQuantity->execute($storageLocation, $item, $quantity, $itemInStorage->pivot->quantity);
        }

        // TODO mark order item as placed

        return new OrderItemResource($orderItem);

    }
}
