<?php

namespace App\Domain\Game\Actions;

class ActionResult {
    public $success = false;
    public $message = "";
    public $data = null;

    public function __construct(
        $success,
        $message,
        $data = null
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }
}
