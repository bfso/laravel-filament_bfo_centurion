<?php

namespace App\Domain\Game\Actions;

use App\Game\Cmd\Command;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class Action
{
    public array $data = [];

    public Player|null $player = null;

    public string $action = '';

    public string $subject = \stdClass::class;

    public static function make(?string $name = null): static
    {
        $static = app(static::class, [
            'name' => $name ?? static::getDefaultName(),
        ]);
        /** @todo maybe better place for this? */
        $static->setUp();

        return $static;
    }

    public function setUp(): void {
        $this->player = Player::with(['mapField.items'])->where('user_id', auth()->user()->id)->first();
    }

    public static function getDefaultName(): ?string
    {
        return null;
    }

    public function payload(array $data): self {
        $this->data = $data;
        return $this;
    }

    public function do(): ActionResult{
        return ActionResult::make('action-does-not-exist');
    }

    public function jsonResponse(): JsonResponse {
        return response()->json($this->do(), 200);
    }
}
