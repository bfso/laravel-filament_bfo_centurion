<?php

namespace App\Domain\Map\Checks;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;

class MapFieldExistsCheck
{
    public static function handle(Action|null $action): ActionResult|null
    {
        if (! $action->mapField) {
            return new ActionResult(
                false,
                "Map field does not exist",
                'map-field-does-not-exist'
            );
        }

        return new ActionResult(
            true,
            'Map field exists',
            'map-field-exists'
        );
    }
}
