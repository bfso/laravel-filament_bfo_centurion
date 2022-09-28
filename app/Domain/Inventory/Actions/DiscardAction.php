<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Inventory\Handler\DiscardInventoryItem;
use App\Domain\Inventory\Handler\FindInventoryItems;

/**
 * Class DiscardAction
 * Discards one item
 */
class DiscardAction extends BaseAction
{
    public function do(): ActionResult
    {
        $inventoryItem = (new FindInventoryItems)(
            $this->command->subject,
            $this->command->player
        )->first();

        if ($inventoryItem) {
            $discardedItem = (new DiscardInventoryItem)(
                $this->command->player->mapField,
                $inventoryItem
            );

            return new ActionResult(
                true,
                'The following items has been discarded:',
                'item-discarded',
                [
                    'items' => [$discardedItem],
                ]
            );
        }

        return new ActionResult(
            false,
            'The items can not be found.',
            'item-not-found'
        );
    }
}
