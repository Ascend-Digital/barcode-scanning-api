<?php

namespace Domain\Orders\Actions;

use App\Exceptions\InvalidItemQuantityException;
use Domain\Orders\Models\OrderItem;
use Domain\Warehouses\Models\StorageLocation;

class PickItem
{
    /**
     * @throws InvalidItemQuantityException
     */
    public function execute(int $quantity, StorageLocation $storageLocation, OrderItem $orderItem): OrderItem
    {
        $item = $orderItem->item;

        // TODO abstract here to l.26 into a separate action/validate method on the model
        $itemInStorage = $storageLocation->items()->findOrFail($item->id);

        $currentQuantity = $itemInStorage
            ->pivot
            ->quantity;

        if ($quantity > $currentQuantity) {
            throw new InvalidItemQuantityException();
        }

        $newQuantity = $currentQuantity - $quantity;

        $storageLocation->items()->updateExistingPivot($item->id, [
            'last_picked_at' => now(),
            'quantity' => $newQuantity,
            'last_picked_quantity' => $quantity,
        ]);

        $orderItem->picked_at = now();
        $orderItem->save();

        return $orderItem;
    }
}
