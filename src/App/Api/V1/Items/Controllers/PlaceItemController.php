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

class PlaceItemController
{
    public function __invoke(
        PlaceItemRequest $placeItemRequest,
        AddItemToStorageLocation $addItemToStorageLocation,
        UpdateItemQuantity $updateItemQuantity,
        Order $order,
        StorageLocation $storageLocation,
        Item $item): OrderItemResource
    {
        $quantity = $placeItemRequest->validated('quantity');
        $itemInStorage = $storageLocation->items()->find($item->id);

        /**
         * @var $orderItem OrderItem
         */
        $orderItem = OrderItem::with('order', 'item')
            ->where('order_id', $order->id)
            ->where('item_id', $item->id)
            ->sole();

        // TODO use DTOs
        if (! $itemInStorage) {
            $addItemToStorageLocation->execute($quantity, $storageLocation, $item);
        } else {
            $updateItemQuantity->execute($storageLocation, $item, $quantity, $itemInStorage->pivot->quantity);
        }

        return new OrderItemResource($orderItem);

    }
}
