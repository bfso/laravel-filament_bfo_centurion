<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Player;

/**
 * Class DiscardAction
 * Discards one item
 *
 * @package App\Game\Actions
 */
class DiscardAction extends BaseAction {

    public function do() {
        /** @var Player $player */
        $player = $this
            ->command
            ->player;

        $inventoryItem = InventoryItem::with('item')->whereHas('item', function($query) {
            return $query->where('key', $this->command->subject);
        })->where('player_id', $player->id)->first();

        if ($inventoryItem) {
            $inventoryItem->delete();
            return new ActionResult(
                true,
                "The following item has been discarded:",
                'item-discarded',
                [
                    'item' => $inventoryItem
                ]
            );
        }
        return new ActionResult(
            false,
            "The item can not be found.",
            "item-not-found"
        );
    }
}
