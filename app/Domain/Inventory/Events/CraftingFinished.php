<?php

namespace App\Domain\Inventory\Events;

use App\Domain\Game\Actions\ActionResult;
use App\Models\Item;
use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CraftingFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ActionResult
     */
    public ActionResult $actionResult;

    /**
     * @var Player
     */
    public Player $player;

    /**
     * @var Item|null
     */
    public Item|null $item;

    /**
     * CraftingFinished constructor.
     *
     * @param ActionResult $actionResult
     * @param Player $player
     * @param Item|null $item
     */
    public function __construct(ActionResult $actionResult, Player $player, Item|null $item = null)
    {
        $this->actionResult = $actionResult;
        $this->player = $player;
        $this->item = $item;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        return new PrivateChannel('channel-name');
    }
}
