<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\InventoryItem;
use App\Models\MapFieldItem;

class TakeAction extends BaseAction
{
    public function do(): ActionResult
    {
        $mapField = $this->mapField = $this
            ->command
            ->player
            ->mapField;
        $items = $mapField->items;
        $item = $items->where('key', $this->command->subject)->first();
        $inventory = $this->command->player->inventories->first();
        $availableSlots = $inventory->slots - $inventory->items->count();

        if ($availableSlots < 1) {
            return new ActionResult(
                false,
                "Can't take that, not enough space.",
                'not-enough-inventory-space'
            );
        }

        if (! $item) {
            return new ActionResult(
                false,
                "Can't take that, no item found.",
                'no-item-found'
            );
        }

        if (! $item->takeable) {
            return new ActionResult(
                false,
                'Not able to take that item.',
                'item-is-not-takeable'
            );
        }

        if (! $inventory) {
            return new ActionResult(
                false,
                "Can't take that, no inventory found.",
                'player-has-no-inventory'
            );
        }

        (new InventoryItem([
            'item_id' => $item->id,
            'inventory_id' => $inventory->id,
        ]))->save();

        MapFieldItem::destroy([$item->pivot->id]);
        //$mapField->items()->detach($item->id);
        return new ActionResult(
            true,
            'The '.$this->command->subject.' is taken',
            'item-is-taken'
        );
    }
}
