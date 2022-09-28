<?php

namespace App\Domain\Inventory\Listeners;

use App\Domain\Inventory\Events\CraftingFinished;
use App\Domain\Quest\Resolvers\CraftTorchQuestResolver;

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
     * @param  CraftingFinished $craftingFinishedEvent
     * @return void
     */
    public function handle(CraftingFinished $craftingFinishedEvent): void
    {
        // @todo
        $quest = Quest::
        (new CraftTorchQuestResolver())->resolve($craftingFinishedEvent->player, );
    }
}
