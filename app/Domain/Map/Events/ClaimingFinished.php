<?php

namespace App\Domain\Map\Events;

use App\Domain\Game\Actions\ActionResult;
use App\Models\Item;
use App\Models\MapField;
use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClaimingFinished
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
     * @var MapField
     */
    public MapField $mapField;

    /**
     * CraftingFinished constructor.
     *
     * @param ActionResult $actionResult
     * @param Player $player
     * @param MapField $mapField
     */
    public function __construct(ActionResult $actionResult, Player $player, MapField $mapField)
    {
        $this->actionResult = $actionResult;
        $this->player = $player;
        $this->mapField = $mapField;
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
