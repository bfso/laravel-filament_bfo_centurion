<?php

namespace App\Domain\Game\Actions;

use App\Game\Cmd\Command;
use App\Models\Player;

abstract class BaseAction {
    protected Command $command;

    public function __construct(Command $command) {
        $this->command = $command;
    }

    public function getSubject() : string {
        return $this->command->subject;
    }

    public function getPlayer() : Player {
        return $this->command->player;
    }

    abstract public function do();
}
