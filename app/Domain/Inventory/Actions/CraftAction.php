<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Inventory\Jobs\Craft;

class CraftAction extends BaseAction
{
    public function do()
    {
        dispatch(new Craft($this->command));
        //$emailJob = (new SendEmailJob())->delay(Carbon::now()->addSeconds(3));
        return new ActionResult(
            true,
            $this->command->subject.' crafting started',
            'crafting-started',
            [
                'created_at' => now(),
                'item_key' => $this->command->subject,
            ]
        );
    }
}
