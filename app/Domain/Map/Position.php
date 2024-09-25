<?php

namespace App\Domain\Map;

class Position
{
    public $x = null;

    public $y = null;

    public $z = null;

    public function __construct(
        $x,
        $y,
        $z = null
    ) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function toArray()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'z' => $this->z,
        ];
    }
}
