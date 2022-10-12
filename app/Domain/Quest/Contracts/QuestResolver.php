<?php

namespace App\Domain\Quest\Contracts;

use App\Domain\Game\Actions\ActionResult;
use App\Models\Player;

interface QuestResolver
{
    public function resolve(Player $player): ActionResult;
}
