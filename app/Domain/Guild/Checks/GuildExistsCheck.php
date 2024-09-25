<?php

namespace App\Domain\Guild\Checks;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;

class GuildExistsCheck
{
    public static function handle(Action|null $action): ActionResult|null
    {
        if (! $action->guild) {
            return new ActionResult(
                false,
                "Guild does not exist",
                'guild-does-not-exist'
            );
        }

        return new ActionResult(
            true,
            'Guild exists',
            'guild-exists'
        );
    }
}
