<?php

namespace App\Domain\Game\Actions;

use App\Domain\Map\Position;

trait HasSubject
{
    public Position $position;
}
