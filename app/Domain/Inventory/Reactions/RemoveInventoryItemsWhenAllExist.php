<?php

namespace App\Domain\Inventory\Reactions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Inventory\Handler\FindInventoryItems;
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
            // Check if the ingredients provided by the player
            // are matching the items blueprint ingredients
            if (!in_array($blueprintItem->key, $command->data['with'])) {
                return new ActionResult(
                    false,
                    $command->action . "ing of " . $command->subject . " not possible since the ingredients are not correct",
                    "ingredients-mismatch"
                );
            }

            // Check if the ingredient is in the players inventory
            /** @todo query in a loop, refactor */
            $inventoryItems = (new FindInventoryItems)(
                $blueprintItem->key,
                $command->player
            )->limit($blueprintItem->pivot->count)->get();

            // Check if the ingredient is available in the right amount
            if ($inventoryItems->count() < $blueprintItem->pivot->count) {
                return new ActionResult(
                    false,
                    $command->action . "ing of " . $command->subject . " not possible since " . $blueprintItem->key . " is missing",
                    "ingredients-missing"
                );
            }
            $itemsToRemove = $itemsToRemove->merge($inventoryItems);
        }

        // Remove all collected ingredients from the players inventory
        InventoryItem::destroy($itemsToRemove->pluck('id'));
        return new ActionResult(
            true,
            "Items successfully removed from inventory",
            "items-removal-successful"
        );
    }
}
