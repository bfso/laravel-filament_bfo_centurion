<?php

namespace App\Game\Worker;

use App\Game\Actions\ActionResult;
use App\Models\InventoryItem;

class CreateNewInventoryItem {
    public static function handle($item, $command) {
        (new InventoryItem([
            'item_id' => $item->id,
            'position-x' => 1,
            'position-y' => 1,
        ]))->save();
        return new ActionResult(true, "Crafting of " . $command->subject . " successful");
    }
}
