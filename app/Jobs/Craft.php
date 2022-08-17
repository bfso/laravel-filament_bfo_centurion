<?php

namespace App\Jobs;

use App\Events\CraftingFinished;
use App\Game\Worker\CreateNewInventoryItem;
use App\Game\Worker\ItemWorker;
use App\Game\Worker\LevelMismatch;
use App\Game\Worker\ItemExists;
use App\Game\Worker\RemoveInventoryItemsWhenAllExist;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Craft implements ShouldQueue, ShouldBeUnique {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ItemWorker;

    protected $item = "";

    protected function itemWithBlueprints() {
        return Item::with('blueprints')
            ->where('key', $this->command->subject)
            ->where($this->command->action . 'able', true)
            ->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->item = $this->itemWithBlueprints();

        CraftingFinished::dispatch($this->run([
            function() {
                return ItemExists::handle($this->item, $this->command);
            },
            function() {
                return LevelMismatch::handle($this->item, $this->command);
            },
            function() {
                return RemoveInventoryItemsWhenAllExist::handle($this->item, $this->command);
            },
            function() {
                return CreateNewInventoryItem::handle($this->item, $this->command);
            },
        ]));
    }
}
