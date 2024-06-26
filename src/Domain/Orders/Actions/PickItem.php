<?php

namespace Domain\Orders\Actions;

use App\Exceptions\InvalidItemQuantityException;
use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;

class PickItem
{
    /**
     * @throws InvalidItemQuantityException
     */
    public function execute(int $quantity, StorageLocation $storageLocation, Item $item): Item
    {
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

        // TODO mark the order item as picked

        return $item;
    }
}
