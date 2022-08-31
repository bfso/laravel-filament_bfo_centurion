<?php

namespace App\Domain\Inventory\Events;

use App\Domain\Game\Actions\ActionResult;
use App\Models\Player;
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
     * @var Player $player
     */
    public Player $player;

    /**
     * CraftingFinished constructor.
     *
     * @param ActionResult $actionResult
     * @param Player $player
     */
    public function __construct(ActionResult $actionResult, Player $player) {
        $this->actionResult = $actionResult;
        $this->player = $player;
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
