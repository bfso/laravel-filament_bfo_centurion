<?php

namespace App\Game\Actions;

use App\Models\InventoryItem;
use App\Models\Item;

class TakeAction extends BaseAction {

    public function do() {
        $mapField = $this->mapField = $this
            ->command
            ->player
            ->mapField;
        $items = $mapField->items;
        $item = $items->where('key',$this->command->subject)->first();
        $inventory = $this->command->player->inventories->first();
        if($item and $inventory){
            (new InventoryItem([
                'item_id' => $item->id,
                'inventory_id' => $inventory->id,
            ]))->save();
            $mapField->items()->detach($item->id);
            return new ActionResult(
                true,
                "The " . $this->command->subject . " is taken"
            );
        }
        return new ActionResult(
            false,
            "Can't take that"
        );
    }
}
