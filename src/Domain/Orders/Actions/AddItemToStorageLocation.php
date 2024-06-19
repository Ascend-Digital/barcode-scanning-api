<?php

namespace Domain\Orders\Actions;

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
//        dd(Item::byStorageLocationRestriction($storageLocation)->get());
        if ($item->whereRelation('storageLocationRestrictions', 'storage_location_id', $storageLocation->id)->exists()) {
            throw new Exception('Item cannot be placed in that storage location');
        };

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
