<?php

namespace App\Domain\Player\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Map\Position;
use App\Models\MapField;
use App\Models\Player;

class ShowPlayerAction extends BaseAction
{
    public function do(): ActionResult
    {
        /** @var Player $player */
        $player = $this->command->player;
        return new ActionResult(
            true,
            'Player',
            'player',
            [
                'player' => $player,
                'position' => $player->mapField->position(),
            ]
        );
    }
}
