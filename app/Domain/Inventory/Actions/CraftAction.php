<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Jobs\Craft;

class CraftAction extends BaseAction {
    public function do() {
        Craft::dispatch($this->command)
            ->delay(2);
        return new ActionResult(
            true,
            $this->command->subject . " crafting started - " . now()
        );
    }
}
