<?php

namespace App\Game\Cmd;

use App\Models\Player;

class Command
{
    public string $action = '';

    public string $subject = '';

    public $data;

    public $player;

    public function __construct(
        string $action,
        string $subject = '',
        $data = null,
        $player = null
    ) {
        $this->action = $action;
        $this->subject = $subject;
        $this->data = $data;
        $this->player =
            ($player === null) ? $this->player = Player::with(['mapField.items'])->where('user_id', auth()->user()->id)->first() :
                $player;
    }
}
