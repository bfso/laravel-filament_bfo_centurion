<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\Inventory;
use App\Models\Player;

/**
 * Class ShowAction
 * Shows the items of all inventories
 */
class ShowAction extends BaseAction
{
    public function do(): ActionResult
    {
        /** @var Player $player */
        $player = $this
            ->command
            ->player;
        Inventory::with('items')->where('player_id', $player->id)->get();

        if ($player->inventories->count() >= 1) {
            return new ActionResult(
                true,
                'You have the following inventories:',
                'player-list-of-inventories',
                [
                    'inventories' => $player->inventories,
                ]
            );
        }

        return new ActionResult(
            false,
            'No inventories found.',
            'player-has-no-inventory'
        );
    }
}
