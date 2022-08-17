<?php

namespace App\Game\Actions;

use App\Game\Cmd\Command;

abstract class BaseAction {
    protected $command;

    public function __construct(Command $command) {
        $this->command = $command;
    }

    abstract public function do();
}
