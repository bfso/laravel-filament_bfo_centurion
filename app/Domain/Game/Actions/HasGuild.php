<?php

namespace App\Domain\Game\Actions;

use App\Models\Guild;

trait HasGuild
{
    public Guild|null $guild = null;
}
