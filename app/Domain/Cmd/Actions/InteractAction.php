<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Inventory\Jobs\Craft;
use App\Domain\Inventory\Jobs\Interact;
use App\Models\Item;
use App\Models\MapFieldItem;

class InteractAction extends BaseAction {

    public function do() {
        dispatch(new Interact($this->command));
        return new ActionResult(
            true,
            "Interacting with ". $this->command->subject . " started",
            "interacting-started",
            [
                'created_at' => now(),
                'with_key' => $this->command->subject
            ]
        );
    }
}
