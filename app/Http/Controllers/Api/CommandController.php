<?php

namespace App\Http\Controllers\Api;

use App\Domain\Game\Factories\ActionFactory;
use App\Domain\Guild\Actions\ShowGuildsAction;
use App\Game\Cmd\Command;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;

class CommandController extends Controller {
    /**
     * @param Command $command
     * @return JsonResponse
     */
    public function sendResponse(Command $command): JsonResponse {
        return response()->json((ActionFactory::create($command))->do(), 200);
    }
}
