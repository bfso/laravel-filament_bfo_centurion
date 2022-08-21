<?php

namespace App\Domain\Cmd\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Map\Position;
use App\Models\MapField;

class GoAction extends BaseAction {

    public function do() {
        $player = $this->command->player;
        $position = new Position($player->mapField->x, $player->mapField->y);

        if ($this->command->subject == "left") {
            return $this->goLeft($player, $position);
        }
        if ($this->command->subject == "right") {
            return $this->goRight($player, $position);
        }
        if ($this->command->subject == "up") {
            return $this->goUp($player, $position);
        }
        if ($this->command->subject == "down") {
            return $this->goDown($player, $position);
        }
        return $this->cantGoThereActionResult();
    }

    public function cantGoThereActionResult() {
        return new ActionResult(
            false,
            "I can't go there"
        );
    }

    public function goRight($player, $position) {
        $newX = $position->x + 1;
        $newMapField = MapField::where('x', $newX)->where('y', $position->y)->first();
        if (!$newMapField) {
            return $this->cantGoThereActionResult();
        }
        $player->map_field_id = $newMapField->id;
        $player->save();
        return new ActionResult(
            true,
            "I went right",
            [
                'x' => $newMapField->x,
                'y' => $newMapField->y,
            ]
        );
    }

    public function goLeft($player, $position) {
        if ($position->x == 1) {
            return $this->cantGoThereActionResult();
        }
        $newX = $position->x - 1;
        $newMapField = MapField::where('x', $newX)->where('y', $position->y)->first();
        if (!$newMapField) {
            return $this->cantGoThereActionResult();
        }
        $player->map_field_id = $newMapField->id;
        $player->save();
        return new ActionResult(
            true,
            "I went left",
            [
                'x' => $newMapField->x,
                'y' => $newMapField->y,
            ]
        );
    }

    public function goUp($player, $position) {
        $newY = $position->y - 1;
        $newMapField = MapField::where('x', $position->x)->where('y', $newY)->first();
        if (!$newMapField) {
            return $this->cantGoThereActionResult();
        }
        $player->map_field_id = $newMapField->id;
        $player->save();
        return new ActionResult(
            true,
            "I went up",
            [
                'x' => $newMapField->x,
                'y' => $newMapField->y,
            ]
        );
    }

    public function goDown($player, $position) {
        $newY = $position->y + 1;
        $newMapField = MapField::where('x', $position->x)->where('y', $newY)->first();
        if (!$newMapField) {
            return $this->cantGoThereActionResult();
        }
        $player->map_field_id = $newMapField->id;
        $player->save();
        return new ActionResult(
            true,
            "I went down",
            [
                'x' => $newMapField->x,
                'y' => $newMapField->y,
            ]
        );
    }
}
