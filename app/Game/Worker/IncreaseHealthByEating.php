<?php

namespace App\Game\Worker;

use App\Game\Actions\ActionResult;

class IncreaseHealthByEating {
    public static function handle($inventoryItem, $command) {
        $player = $command->player;
        $player->health = $player->health + $inventoryItem->item->restores_health_by;
        $player->save();
        $inventoryItem->delete();
        return new ActionResult(
            true,
            "Your health is restored"
        );
    }
}
