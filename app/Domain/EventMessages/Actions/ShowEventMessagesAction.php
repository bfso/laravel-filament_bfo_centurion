<?php

namespace App\Domain\EventMessages\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\EventMessage;
use App\Models\Player;

/**
 * Class ShowAction
 * Shows the items of all inventories
 */
class ShowEventMessagesAction extends BaseAction
{
    public function do(): ActionResult
    {
        /** @var Player $player */
        $player = $this
            ->command
            ->player;
        $eventMessages = EventMessage::where('player_id', $player->id)
            ->orderBy('updated_at', 'DESC')
            ->limit(10)
            ->get();

        if ($eventMessages->count() >= 1) {
            return new ActionResult(
                true,
                'You have the following event messages:',
                'event-messages-list',
                [
                    'event-messages' => $eventMessages,
                ]
            );
        }

        return new ActionResult(
            true,
            'No event messages found.',
            'no-event-messages'
        );
    }
}
