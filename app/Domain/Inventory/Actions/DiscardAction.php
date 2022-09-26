<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Inventory\Handler\FindInventoryItem;
use App\Models\InventoryItem;

/**
 * Class DiscardAction
 * Discards one item
 *
 * @package App\Game\Actions
 */
class DiscardAction extends BaseAction {

    public function do() {
        $inventoryItem  = (new InventoryItem)(
            $this->command->subject,
            $this->command->player
        );

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
