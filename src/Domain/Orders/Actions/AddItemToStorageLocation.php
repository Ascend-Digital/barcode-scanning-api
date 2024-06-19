<?php

namespace Domain\Orders\Actions;

use App\Exceptions\RestrictedItemException;
use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;
use Exception;

class AddItemToStorageLocation
{
    /**
     * @throws Exception
     */
    public function execute(int $quantity, StorageLocation $storageLocation, Item $item): Item
    {
        if (! $item->canBePlacedInStorageLocation($storageLocation)) {
            throw new RestrictedItemException();
        }

        // TODO explore whether this should be in a transaction
        $storageLocation->items()->attach(
            $item->id, [
                'quantity' => $quantity,
                'last_placed_at' => now(),
                'last_placed_quantity' => $quantity,
            ]
        );

        return $item;
    }
}
