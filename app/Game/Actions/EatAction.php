<?php

namespace App\Game\Actions;

use App\Jobs\Eat;

class EatAction extends BaseAction {

    public function do(){
        Eat::dispatch($this->command)
            ->delay(2);
        return new ActionResult(
            true,
            $this->command->subject . " eating started - " . now()
        );
    }
}
