<?php

namespace App\Domain\Guild\Actions;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;
use App\Models\Guild;
use App\Models\Player;

class ApproveGuildAction extends Action
{

    public function do(): ActionResult
    {
        $guild = Guild::where('name', $this->data['name'])->firstOrFail();

        $guild->players()->updateExistingPivot($this->data['player_id'], ['is_approved' => true]);

        return ActionResult::make('approved-guild')
            ->message('Approved player to guild: ' . $guild->name)
            ->data(
                [
                    'guild' => $guild->toArray(),
                    'player' => $this->player->toArray(),
                ],
            )
            ->success();
    }
}
