<?php

namespace App\Domain\Map\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\HasGuild;
use App\Domain\Game\Actions\HasMapField;
use App\Domain\Map\Jobs\Claim;
use App\Domain\Game\Actions\Action;
use App\Models\Guild;

class ClaimAction extends Action
{
    use HasMapField;
    use HasGuild;

    public function do(): ActionResult
    {
        Claim::dispatch($this)
            ->delay(2);

        return new ActionResult(
            true,
            'claiming started - '.now(),
            'claiming-started'
        );
    }
}
