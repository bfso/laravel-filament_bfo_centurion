<?php

namespace App\Domain\Inventory\Jobs;

use App\Domain\Inventory\Events\ClaimingFinished;
use App\Domain\Inventory\Reactions\CreateNewInventoryItem;
use App\Domain\Inventory\Reactions\RemoveInventoryItemsWhenAllExist;
use App\Domain\Item\Checks\ItemExistsCheck;
use App\Domain\Item\Checks\LevelMismatchCheck;
use App\Domain\Worker\CommandWorker;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class Craft implements ShouldQueue, ShouldBeUnique {
    //
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use CommandWorker;

    protected function getItem(): Model {
        return Item::with('requires')
            ->where('key', $this->command->subject)
            ->where($this->command->action . 'able', true)
            ->first();
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle() {
        $item = $this->getItem();
        $actionResult = $this->run(
            $item,
            [
                function($item) {
                    return ItemExistsCheck::handle($item, $this->command);
                },
                function($item) {
                    return LevelMismatchCheck::handle($item, $this->command);
                },
                function($item) {
                    return RemoveInventoryItemsWhenAllExist::handle($item, $this->command);
                },
                function($item) {
                    return CreateNewInventoryItem::handle($item, $this->command);
                },
            ]
        );

        //(new CraftingFinished($actionResult, $this->command->player, $item))::dispatch();
        ClaimingFinished::dispatch($actionResult, $this->command->player, $item);
    }
}
