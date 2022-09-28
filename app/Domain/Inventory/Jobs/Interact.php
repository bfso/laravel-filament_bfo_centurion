<?php

namespace App\Domain\Inventory\Jobs;

use App\Domain\Cmd\Reactions\HandleInteractionResult;
use App\Domain\Inventory\Events\CraftingFinished;
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

class Interact implements ShouldQueue, ShouldBeUnique
{
 //
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use CommandWorker;

    protected function getItem(): Model
    {
        return Item::with('requires')
            ->where('key', $this->command->subject)
            ->where($this->command->action.'able', true)
            ->first();
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $item = $this->getItem();

        CraftingFinished::dispatch($this->run(
            $item,
            [
                function ($item) {
                    return ItemExistsCheck::handle($item, $this->command);
                },
                function ($item) {
                    return LevelMismatchCheck::handle($item, $this->command);
                },
                function ($item) {
                    return HandleInteractionResult::handle($item, $this->command);
                },
            ]), $this->command->player);
    }
}
