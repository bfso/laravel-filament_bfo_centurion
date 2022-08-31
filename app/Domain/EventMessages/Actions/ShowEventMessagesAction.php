<?php

namespace App\Domain\EventMessages\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\EventMessage;
use App\Models\Inventory;
use App\Models\Player;
use App\Models\PlayerQuest;
use Illuminate\Support\Str;

/**
 * Class ShowAction
 * Shows the items of all inventories
 *
 * @package App\Game\Actions
 */
class ShowEventMessagesAction extends BaseAction {

    public function do() {
        /** @var Player $player */
        $player = $this
            ->command
            ->player;
        $eventMessages = EventMessage::where('player_id',$player->id)
            ->orderBy('updated_at','DESC')
            ->limit(10)
            ->get();

        if ($eventMessages->count() >= 1) {
            return new ActionResult(
                true,
                "You have the following event messages:",
                "event-messages-list",
                [
                    'event-messages' => $eventMessages
                ]
            );
        }
        return new ActionResult(
            true,
            "No event messages found.",
            "no-event-messages"
        );
    }

}
