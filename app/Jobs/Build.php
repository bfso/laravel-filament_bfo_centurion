<?php

namespace App\Jobs;

use App\Events\CraftingFinished;
use App\Game\Worker\CreateNewMapFieldItem;
use App\Game\Worker\ItemExists;
use App\Game\Worker\LevelMismatchCheck;
use App\Game\Worker\RemoveInventoryItemsWhenAllExist;

class Build extends Craft
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->item = $this->itemWithBlueprints();

        $actionResult = $this->run([
            function () {
                return ItemExists::handle($this->item, $this->command);
            },
            function () {
                return LevelMismatchCheck::handle($this->item, $this->command);
            },
            function () {
                return RemoveInventoryItemsWhenAllExist::handle($this->item, $this->command);
            },
            function () {
                return CreateNewMapFieldItem::handle($this->item, $this->command);
            },
        ]);

        CraftingFinished::dispatch($actionResult);
    }
}
