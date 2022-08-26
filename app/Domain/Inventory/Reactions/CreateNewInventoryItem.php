<?php

namespace App\Domain\Inventory\Reactions;

use App\Domain\Game\Actions\ActionResult;
use App\Models\Inventory;
use App\Models\InventoryItem;

class CreateNewInventoryItem {
    public static function handle($item, $command) {
        $inventory = Inventory::where('player_id', $command->player->id)->first();
        (new InventoryItem([
            'item_id' => $item->id,
            'inventory_id' => $inventory->id,
        ]))->save();
        return new ActionResult(true, "Crafting of " . $command->subject . " successful");
    }
}
