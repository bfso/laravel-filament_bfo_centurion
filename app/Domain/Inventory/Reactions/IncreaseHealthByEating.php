<?php

namespace App\Domain\Inventory\Reactions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Inventory\Handler\FindInventoryItems;

class IncreaseHealthByEating
{
    public static function handle($item, $command)
    {
        $player = $command->player;

        $inventoryItem = (new FindInventoryItems)(
            $item->key,
            $player
        )->first();

        if (! $inventoryItem) {
            return new ActionResult(
                false,
                "It's not possible to restore your health, since the item doesn't exist in your inventory",
                'item-not-in-inventory'
            );
        }

        if (! $inventoryItem->item->eatable) {
            return new ActionResult(
                false,
                "It's not possible to restore your health, since the item is not eatable",
                'item-not-eatable'
            );
        }

        $player->health = $player->health + $item->restores_health_by;
        $player->save();
        $inventoryItem->delete();

        return new ActionResult(
            true,
            'Your health is restored',
            'health-restored'
        );
    }
}
