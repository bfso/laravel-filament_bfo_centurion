<?php

namespace App\Game\Actions;

use App\Models\MapField;

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
                ['items' => $items]
            );
        }
        return new ActionResult(
            true,
            "There is not much to speak of."
        );
    }
}
