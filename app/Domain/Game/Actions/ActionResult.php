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

    public static function make(string $key = '') : self
    {
        return new self(false, '', $key);
    }

    public function message(string $message) : self
    {
        $this->message = $message;
        return $this;
    }

    public function data(array $data) : self
    {
        $this->data = $data;
        return $this;
    }

    public function success() : self
    {
        $this->success = true;
        return $this;
    }

    public function fail() : self
    {
        $this->success = false;
        return $this;
    }
}
