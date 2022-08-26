<?php

namespace App\Domain\Inventory\Jobs;

use App\Domain\Inventory\Events\CraftingFinished;
use App\Domain\Inventory\Reactions\IncreaseHealthByEating;
use App\Domain\Item\Checks\ItemExistsCheck;

class Eat extends Craft {

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $item = $this->getItem();

        $actionResult = $this->run($item,[
            function($item) {
                return ItemExistsCheck::handle($item, $this->command);
            },
            function($item) {
                return IncreaseHealthByEating::handle($item, $this->command);
            },
        ]);

        CraftingFinished::dispatch($actionResult);
    }
}
