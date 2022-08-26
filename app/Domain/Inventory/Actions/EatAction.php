<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Inventory\Jobs\Eat;

class EatAction extends BaseAction {

    public function do(){
        dispatch(new Eat($this->command));
        return new ActionResult(
            true,
            $this->command->subject . " eating started - " . now()
        );
    }
}