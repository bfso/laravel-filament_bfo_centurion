<?php

namespace App\Domain\Inventory\Handler;

use App\Models\InventoryItem;
use App\Models\Item;
use App\Models\MapField;

class DiscardInventoryItem
{
    public function __invoke(MapField $mapField, InventoryItem $inventoryItem): Item
    {
        $item = $inventoryItem->item;
        $mapField->items()->attach($item);
        $inventoryItem->delete();

        return $item;
    }
}
