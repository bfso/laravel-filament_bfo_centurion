<?php

namespace App\Domain\Game\Actions;

use App\Domain\Map\Position;

trait HasPosition
{
    public Position $position;
}
