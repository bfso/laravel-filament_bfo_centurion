<?php

namespace App\Game\Worker;

use App\Game\Actions\ActionResult;
use App\Game\Cmd\Command;
use App\Models\InventoryItem;
use App\Models\Item;

class RemoveInventoryItemsWhenAllExist {
    /**
     * @param Item $item
     * @param Command $command
     * @return ActionResult
     */
    public static function handle(Item $item, Command $command): ActionResult {
        $itemsToRemove = collect();
        foreach ($item->blueprints as $blueprintItem) {
            $inventoryItems = InventoryItem::with('item')->whereHas('item', function($query) use ($blueprintItem) {
                return $query->where('key', $blueprintItem->key);
            })->limit($blueprintItem->pivot->count)->get();

            if ($inventoryItems->count() < $blueprintItem->pivot->count) {
                return new ActionResult(
                    false,
                    $command->action . "ing of " . $command->subject . " not possible since " . $blueprintItem->key . " is missing"
                );
            }
            $itemsToRemove = $itemsToRemove->merge($inventoryItems);
        }

        InventoryItem::destroy($itemsToRemove->pluck('id'));
        return new ActionResult(
            true,
            "Items successfully removed from inventory"
        );
    }
}
