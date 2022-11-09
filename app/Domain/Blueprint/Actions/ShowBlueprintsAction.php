<?php

namespace App\Domain\Blueprint\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\Item;

class ShowBlueprintsAction extends BaseAction
{
    public function do(): ActionResult
    {
        $items = Item::query()
            ->with('requires')
            ->where('craftable',true)
            ->where('requires_level_to_research','<=',$this->command->player->level)
            ->get();

        return new ActionResult(
            true,
            'Blueprints',
            'blueprints',
            [
                'items' => $items,
            ]
        );
    }
}
