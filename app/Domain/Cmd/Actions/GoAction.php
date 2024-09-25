<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Map\Position;
use App\Models\MapField;

class GoAction extends BaseAction
{
    public function do(): ActionResult
    {
        $player = $this->command->player;
        $position = new Position($player->mapField->x, $player->mapField->y);

        if ($this->command->subject == 'left') {
            return $this->goLeft($position);
        }
        if ($this->command->subject == 'right') {
            return $this->goRight($position);
        }
        if ($this->command->subject == 'up') {
            return $this->goUp($position);
        }
        if ($this->command->subject == 'down') {
            return $this->goDown($position);
        }

        return $this->cantGoThereActionResult();
    }

    protected function goRight(Position $position): ActionResult
    {
        $newX = $position->x + 1;
        $newMapField = MapField::where('x', $newX)->where('y', $position->y)->first();

        return $this->goToMapField($newMapField);
    }

    protected function goLeft(Position $position): ActionResult
    {
        $newX = $position->x - 1;
        $newMapField = MapField::where('x', $newX)->where('y', $position->y)->first();

        return $this->goToMapField($newMapField);
    }

    protected function goUp(Position $position): ActionResult
    {
        $newY = $position->y - 1;
        $newMapField = MapField::where('x', $position->x)->where('y', $newY)->first();

        return $this->goToMapField($newMapField);
    }

    protected function goDown(Position $position): ActionResult
    {
        $newY = $position->y + 1;
        $newMapField = MapField::where('x', $position->x)->where('y', $newY)->first();

        return $this->goToMapField($newMapField);
    }

    public function goToMapField(MapField|null $newMapField): ActionResult
    {
        if (! $newMapField) {
            return $this->cantGoThereActionResult();
        }

        if ($newMapField->isBlocked()) {
            return $this->newPositionIsBlockedActionResult();
        }

        $this->command->player->map_field_id = $newMapField->id;
        $this->command->player->save();

        return new ActionResult(
            true,
            'I went '.$this->command->subject,
            'player-new-position',
            [
                'position' => $newMapField->position(),
            ]
        );
    }

    public function newPositionIsBlockedActionResult(): ActionResult
    {
        return new ActionResult(
            false,
            "I can't go there",
            'new-position-is-blocked'
        );
    }

    public function cantGoThereActionResult(): ActionResult
    {
        return new ActionResult(
            false,
            "I can't go there",
            'new-position-not-possible'
        );
    }
}
