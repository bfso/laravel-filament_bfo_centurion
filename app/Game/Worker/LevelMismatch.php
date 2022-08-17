<?php

namespace App\Game\Worker;

use App\Game\Actions\ActionResult;

class LevelMismatch {
    public static function handle($item, $command) {
        if ($item->level > $command->player->level) {
            return new ActionResult(
                false,
                "You need to reach level " . $item->level . " to do that."
            );
        }
        return new ActionResult(true, "");
    }
}
