<?php

namespace App\Domain\Inventory\Listeners;

use App\Domain\Inventory\Events\CraftingFinished;
use App\Domain\Quest\Resolvers\CraftTorchQuestResolver;
use App\Models\EventMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ResolveCraftingQuests
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CraftingFinished  $event
     * @return void
     */
    public function handle(CraftingFinished $event)
    {
        // @todo command is missing here to resolve a quest automatically
        // (new CraftTorchQuestResolver())->resolve();
    }
}
