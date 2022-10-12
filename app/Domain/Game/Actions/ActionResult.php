<?php

namespace App\Domain\Game\Actions;

class ActionResult
{
    public bool $success = false;

    public string $message = '';

    public string|null $key = null;

    public array|null $data = null;

    public function __construct(
        $success,
        $message,
        $key = '',
        $data = null
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->key = $key;
        $this->data = $data;
    }
}
