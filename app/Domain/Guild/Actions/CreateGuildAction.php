<?php

namespace App\Domain\Guild\Actions;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;
use App\Models\Guild;

class CreateGuildAction extends Action
{
    public function do(): ActionResult
    {
        $guild = Guild::create([
            'name' => $this->data['name'],
            'description' => $this->data['description'],
        ]);

        $guild->players()->attach($this->player, ['is_approved' => true, 'is_owner' => true]);

        return ActionResult::make('create-guild')
            ->message('Created new guild: ' . $guild->name)
            ->data(
                [
                    'guild' => $guild->toArray(),
                ],
            )
            ->success();
    }
}
