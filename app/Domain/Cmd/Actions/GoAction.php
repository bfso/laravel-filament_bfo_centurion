<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Map\Position;
use App\Models\MapField;

class GoAction extends BaseAction
{
    public function do()
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

    protected function goRight($position)
    {
        $newX = $position->x + 1;
        $newMapField = MapField::where('x', $newX)->where('y', $position->y)->first();

        return $this->goToMapField($newMapField);
    }

    protected function goLeft($position)
    {
        $newX = $position->x - 1;
        $newMapField = MapField::where('x', $newX)->where('y', $position->y)->first();

        return $this->goToMapField($newMapField);
    }

    protected function goUp($position)
    {
        $newY = $position->y - 1;
        $newMapField = MapField::where('x', $position->x)->where('y', $newY)->first();

        return $this->goToMapField($newMapField);
    }

    protected function goDown($position)
    {
        $newY = $position->y + 1;
        $newMapField = MapField::where('x', $position->x)->where('y', $newY)->first();

        return $this->goToMapField($newMapField);
    }

    public function goToMapField($newMapField)
    {
        if (! $newMapField) {
            return $this->cantGoThereActionResult();
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

    public function cantGoThereActionResult()
    {
        return new ActionResult(
            false,
            "I can't go there",
            'new-position-not-possible'
        );
    }
}
