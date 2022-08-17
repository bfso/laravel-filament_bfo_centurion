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
        if($item){
            (new InventoryItem([
                'item_id' => $item->id,
                'position-x' => 1,
                'position-y' => 1,
            ]))->save();
            $mapField->items()->detach($item->id);
            return new ActionResult(
                true,
                "The " . $this->command->subject . " is now in your bag"
            );
        }
        return new ActionResult(
            false,
            "Can't take that"
        );
    }
}
