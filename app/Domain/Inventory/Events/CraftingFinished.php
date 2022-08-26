<?php

namespace App\Domain\Inventory\Events;

use App\Domain\Game\Actions\ActionResult;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CraftingFinished {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ActionResult
     */
    public ActionResult $actionResult;

    /**
     * Create a new event instance.
     *
     * @param ActionResult $actionResult
     */
    public function __construct(ActionResult $actionResult) {
        $this->actionResult = $actionResult;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
