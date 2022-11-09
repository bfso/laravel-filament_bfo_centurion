<?php

namespace App\Domain\Item\Checks;

use App\Domain\Game\Actions\ActionResult;

class LevelMismatchCheck
{
    public static function handle($item, $command): ActionResult
    {
        if ($item->requires_level_to_craft > $command->player->requires_level_to_craft) {
            return new ActionResult(
                false,
                'You need to reach level '.$item->requires_level_to_craft.' to do that.',
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
