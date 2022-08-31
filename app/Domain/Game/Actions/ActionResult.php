<?php

namespace App\Domain\Game\Actions;

class ActionResult {
    public $success = false;
    public $message = "";
    public $key = null;
    public $data = null;

    public function __construct(
        $success,
        $message,
        $key = "",
        $data = null
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->key = $key;
        $this->data = $data;
    }
}
