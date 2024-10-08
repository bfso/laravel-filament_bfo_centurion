<?php

namespace App\Domain\Map\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Map\Jobs\Build;

class BuildAction extends BaseAction
{
    public function do(): ActionResult
    {
        Build::dispatch($this->command)
            ->delay(2);

        return new ActionResult(
            true,
            $this->command->subject.' building started - '.now(),
            'building-started'
        );
    }
}
