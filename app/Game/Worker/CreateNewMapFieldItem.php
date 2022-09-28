<?php

namespace App\Game\Worker;

use App\Game\Actions\ActionResult;
use App\Models\MapFieldItem;

class CreateNewMapFieldItem
{
    public static function handle($item, $command)
    {
        $player = $command->player;

        (new MapFieldItem([
            'item_id' => $item->id,
            'map_field_id' => $player->mapField->id,
            'player_id' => $player->id,
        ]))->save();

        return new ActionResult(true, 'Building of '.$command->subject.' successful');
    }
}
