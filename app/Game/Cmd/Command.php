<?php

namespace App\Game\Cmd;

class Command {
    public $action = "";
    public $subject = "";
    public $scope = "";
    public $player = "";

    public function __construct(
        $command,
        $scope,
        $player
    ) {
        $this->scope = $scope;
        $this->player = $player;

        $commandParts = explode(' ', $command);
        if (isset($commandParts[0])) {
            $this->action = $commandParts[0];
        }
        if (isset($commandParts[1])) {
            $this->subject = $commandParts[1];
        }
    }
}
