<?php

namespace App\Domain\Inventory\Reactions;


use App\Domain\Game\Actions\ActionResult;
use App\Models\InventoryItem;

class IncreaseHealthByEating {
    public static function handle($item, $command) {
        $inventoryItem = InventoryItem::with(['item', 'inventory'])
            ->whereHas('inventory', function($query) use ($command) {
                return $query->where('player_id', $command->player->id);
            })
            ->whereHas('item', function($query) use ($item) {
                return $query->where('key', $item->key);
            })->first();

        if(!$inventoryItem){
            return new ActionResult(
                false,
                "It's not possible to restore your health, since the item doesn't exist in your inventory"
            );
        }

        $player = $command->player;
        $player->health = $player->health + $item->restores_health_by;
        $player->save();
        $inventoryItem->delete();
        return new ActionResult(
            true,
            "Your health is restored"
        );
    }
}
