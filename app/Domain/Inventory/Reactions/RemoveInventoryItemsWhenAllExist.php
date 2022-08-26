<?php

namespace App\Domain\Inventory\Reactions;

use App\Domain\Game\Actions\ActionResult;
use App\Game\Cmd\Command;
use App\Models\InventoryItem;
use App\Models\Item;
use Illuminate\Support\Arr;

class RemoveInventoryItemsWhenAllExist {
    /**
     * @param Item $item
     * @param Command $command
     * @return ActionResult
     */
    public static function handle(Item $item, Command $command): ActionResult {
        $itemsToRemove = collect();
        foreach ($item->blueprints as $blueprintItem) {
            if (!in_array($blueprintItem->key, $command->data['with'])) {
                return new ActionResult(
                    false,
                    $command->action . "ing of " . $command->subject . " not possible since the ingredients are not correct"
                );
            }

            $inventoryItems = InventoryItem::with(['item', 'inventory'])
                ->whereHas('inventory', function($query) use ($command) {
                    return $query->where('player_id', $command->player->id);
                })
                ->whereHas('item', function($query) use ($blueprintItem) {
                    return $query->where('key', $blueprintItem->key);
                })
                ->limit($blueprintItem->pivot->count)->get();

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
