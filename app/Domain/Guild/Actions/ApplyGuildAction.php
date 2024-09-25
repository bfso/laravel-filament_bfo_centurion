<?php

namespace App\Domain\Guild\Actions;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;
use App\Models\Guild;

class ApplyGuildAction extends Action
{

    public function do(): ActionResult
    {
        $guild = Guild::where('name', $this->data['name'])->with('players')->firstOrFail();
        if($guild->players->contains($this->player)){
            return ActionResult::make('player-already-in-guild')
                ->message('Player already in guild: ' . $guild->name)
                ->data(
                    [
                        'guild' => $guild->toArray(),
                        'player' => $this->player->toArray(),
                    ],
                )
                ->success();
        }

        $guild->players()->attach($this->player, ['is_approved' => false, 'is_owner' => false]);

        return ActionResult::make('applied-to-guild')
            ->message('Applied to guild: ' . $guild->name)
            ->data(
                [
                    'guild' => $guild->toArray(),
                    'player' => $this->player->toArray(),
                ],
            )
            ->success();
    }
}
