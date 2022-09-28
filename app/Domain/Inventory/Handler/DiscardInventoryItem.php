<?php

namespace App\Domain\Inventory\Handler;

class DiscardInventoryItem
{
    public function __invoke($mapField, $inventoryItem)
    {
        $item = $inventoryItem->item;
        $mapField->items()->attach($item);
        $inventoryItem->delete();

        return $item;
    }
}
