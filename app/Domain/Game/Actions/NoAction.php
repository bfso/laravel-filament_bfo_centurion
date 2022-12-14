<?php

namespace App\Domain\Game\Actions;

class NoAction extends BaseAction
{
    public function do(): ActionResult
    {
        return new ActionResult(
            false,
            "This action doesn't exist",
            'action-does-not-exist'
        );
    }
}
