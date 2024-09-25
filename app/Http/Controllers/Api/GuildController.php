<?php

namespace App\Http\Controllers\Api;

use App\Domain\Guild\Actions\ApplyGuildAction;
use App\Domain\Guild\Actions\ApproveGuildAction;
use App\Domain\Guild\Actions\CreateGuildAction;
use App\Domain\Guild\Actions\ShowGuildsAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuildController extends CommandController {
    public function index(): JsonResponse {
        return ShowGuildsAction::make()
            ->jsonResponse();
    }

    public function apply(Request $request): JsonResponse {
        return ApplyGuildAction::make()
            ->payload($request->all())
            ->jsonResponse();
    }

    public function approve(Request $request): JsonResponse {
        return ApproveGuildAction::make()
            ->payload($request->all())
            ->jsonResponse();
    }

    public function create(Request $request): JsonResponse {
        return CreateGuildAction::make()
            ->payload($request->all())
            ->jsonResponse();
    }
}
