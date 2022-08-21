<?php

namespace App\Game\Worker;

use App\Domain\Game\Actions\ActionResult;
use App\Game\Cmd\Command;
use App\Models\Item;

class ItemExists {
    /**
     * @param Item $item
     * @param Command $command
     * @return ActionResult
     */
    public static function handle(Item $item, Command $command): ActionResult {
        if (!$item) {
            return new ActionResult(
                false,
                "I don't know how to " . $command->action . " a " . $command->subject
            );
        }
        return new ActionResult(true, "");
    }
}
