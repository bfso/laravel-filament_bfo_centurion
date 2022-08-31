<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;

class LookAction extends BaseAction {

    public function do() {
        $items = $this
            ->command
            ->player
            ->mapField
            ->items;

        if ($items->count() >= 1) {
            return new ActionResult(
                true,
                "There are things to see:",
                "visible-on-map-field",
                ['items' => $items]
            );
        }
        return new ActionResult(
            true,
            "There is not much to speak of.",
            "nothing-visible-on-map-field"
        );
    }
}
