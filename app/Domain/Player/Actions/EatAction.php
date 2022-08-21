<?php

namespace App\Domain\Player\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
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
