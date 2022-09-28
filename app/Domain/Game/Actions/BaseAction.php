<?php

namespace App\Domain\Game\Actions;

use App\Game\Cmd\Command;

abstract class BaseAction
{
    protected Command $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    abstract public function do();
}
