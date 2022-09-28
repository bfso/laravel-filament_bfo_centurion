<?php

namespace App\Domain\Item\Checks;

use App\Domain\Game\Actions\ActionResult;

class LevelMismatchCheck
{
    public static function handle($item, $command): ActionResult
    {
        if ($item->level > $command->player->level) {
            return new ActionResult(
                false,
                'You need to reach level '.$item->level.' to do that.',
                'level-mismatch'
            );
        }

        return new ActionResult(
            true,
            '',
            'level-okay'
        );
    }
}
