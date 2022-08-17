<?php

namespace App\Game\Actions;

use App\Jobs\Build;

class BuildAction extends BaseAction {
    public function do() {
        Build::dispatch($this->command)
            ->delay(2);
        return new ActionResult(
            true,
            $this->command->subject . " building started - " . now()
        );
    }
}
