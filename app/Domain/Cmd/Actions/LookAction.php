<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;

class LookAction extends BaseAction
{
    public function do(): ActionResult
    {
        $player = $this
            ->command
            ->player;

        $items = $player
            ->mapField
            ->items;

        $players = $player
            ->mapField
            ->players;

        $players = $players->filter(function ($otherPlayer, $key) use ($player) {
            return $otherPlayer->id != $player->id;
        });

        if ($items->count() >= 1 || $players->count() >= 1) {
            return new ActionResult(
                true,
                'There are things to see:',
                'visible-on-map-field',
                [
                    'items' => $items,
                    'position' => $player->mapField->position(),
                    'guild' => $player->mapField->owner,
                    'players' => $players->flatten(),
                ]
            );
        }

        return new ActionResult(
            true,
            'There is not much to speak of.',
            'nothing-visible-on-map-field'
        );
    }
}
