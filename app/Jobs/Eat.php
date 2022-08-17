<?php

namespace App\Jobs;

use App\Events\CraftingFinished;
use App\Game\Worker\IncreaseHealthByEating;
use App\Game\Worker\ItemExists;
use App\Models\InventoryItem;

class Eat extends Craft {

    protected $inventoryItem;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->inventoryItem = InventoryItem::with('item')->whereHas('item', function ($query) {
            return $query->where('key', $this->command->subject)->where('eatable',true);
        })->first();

        $actionResult = $this->run( [
            function() {
                return ItemExists::handle($this->inventoryItem, $this->command);
            },
            function() {
                return IncreaseHealthByEating::handle($this->inventoryItem, $this->command);
            },
        ]);

        CraftingFinished::dispatch($actionResult);
    }
}
