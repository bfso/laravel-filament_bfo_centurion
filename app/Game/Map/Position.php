<?php

namespace App\Game\Map;

class Position {
    public $x = null;
    public $y = null;

    public function __construct(
        $x,
        $y
    ) {
        $this->x = $x;
        $this->y = $y;
    }
}
