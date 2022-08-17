<?php

namespace App\Events;

use App\Game\Actions\ActionResult;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CraftingFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $actionResult;
    /**
     * Create a new event instance.
     *
     * @param ActionResult $actionResult
     */
    public function __construct(ActionResult $actionResult)
    {
        $this->actionResult = $actionResult;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
