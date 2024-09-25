<?php

namespace App\Domain\Inventory\Listeners;

use App\Domain\Inventory\Events\ClaimingFinished;
use App\Domain\Quest\Factories\QuestResolverFactory;

class ResolveCraftingQuests {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param ClaimingFinished $craftingFinishedEvent
     * @return void
     */
    public function handle(ClaimingFinished $craftingFinishedEvent): void {
        $itemKey = $craftingFinishedEvent->item->key;
        $resolver = (new QuestResolverFactory)('craft-'.$itemKey);
        $resolver?->resolve($craftingFinishedEvent->player);
    }
}
