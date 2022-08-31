<?php

namespace App\Domain\Game\Listeners;

use App\Domain\Inventory\Events\CraftingFinished;
use App\Models\EventMessage;

class StoreQueuedActionFinnishMessage
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
        $eventMessage = new EventMessage([
            'is_successful' => $event->actionResult->success,
            'message' => $event->actionResult->message,
            'key' => $event->actionResult->key,
            'data' => $event->actionResult->data,
            'player_id' => $event->player->id,
        ]);
        $eventMessage->save();
    }
}
