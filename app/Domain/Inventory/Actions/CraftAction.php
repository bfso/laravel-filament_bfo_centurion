<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Inventory\Jobs\Craft;

class CraftAction extends BaseAction {
    public function do() {

        //$item = Item::with('blueprints')
        //    ->where('key', $this->command->subject)
        //    ->where($this->command->action . 'able', true)
        //    ->first();
        //
        //return RemoveInventoryItemsWhenAllExist::handle($item, $this->command);


        dispatch(new Craft($this->command));
        //$emailJob = (new SendEmailJob())->delay(Carbon::now()->addSeconds(3));
        return new ActionResult(
            true,
            $this->command->subject . " crafting started - " . now()
        );
    }
}
