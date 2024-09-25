<?php

namespace App\Http\Controllers\Api;


use App\Domain\Map\Actions\ClaimAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MapController extends CommandController {
    public function claim(Request $request): JsonResponse {
        return ClaimAction::make()
            ->payload($request->all())
            ->jsonResponse();
    }
}
