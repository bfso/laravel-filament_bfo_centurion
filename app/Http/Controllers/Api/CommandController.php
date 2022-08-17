<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use App\Game\Factories\ActionFactory;
use App\Models\Player;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;

class CommandController extends Controller {

    /**
     * @param $command
     * @return JsonResponse
     */
    public function do($command) {
        $command = new Command(
            $command,
            static::class,
            Player::with(['mapField.items'])->where('user_id', auth()->user()->id)->first()
        );
        return response()->json((ActionFactory::create($command))->do(), 200);
    }
}
