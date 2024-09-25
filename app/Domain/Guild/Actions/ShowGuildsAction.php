<?php

namespace App\Domain\Guild\Actions;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;
use App\Models\Guild;

class ShowGuildsAction extends Action {

    public function do(): ActionResult {
        return ActionResult::make('show-guilds')
            ->message('Guilds shown')
            ->data(
                [
                    'guilds' => Guild::with('players')
                        ->get()
                        ->toArray(),
                ]
            )
            ->success();
    }
}
