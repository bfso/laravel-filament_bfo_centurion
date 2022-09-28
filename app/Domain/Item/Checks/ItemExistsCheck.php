<?php

namespace App\Domain\Item\Checks;

use App\Domain\Game\Actions\ActionResult;
use App\Game\Cmd\Command;
use App\Models\Item;

class ItemExistsCheck
{
    /**
     * @param  Item|null  $item
     * @param  Command  $command
     * @return ActionResult
     */
    public static function handle(Item|null $item, Command $command)
    {
        if (! $item) {
            return new ActionResult(
                false,
                "I don't know how to ".$command->action.' a '.$command->subject,
                'item-does-not-exist'
            );
        }

        return new ActionResult(
            true,
            'I know how to '.$command->action.' a '.$command->subject,
            'item-exists'
        );
    }
}
