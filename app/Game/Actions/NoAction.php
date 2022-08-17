<?php

namespace App\Game\Actions;

class NoAction extends BaseAction  {

    public function do() {
        return new ActionResult(
            false,
            "This action doesn't exist"
        );
    }
}
