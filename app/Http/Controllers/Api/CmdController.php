<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CmdController extends CommandController {
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function look(Request $request): JsonResponse {
        return $this->sendResponse(
            new Command(
                'look'
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function go(Request $request): JsonResponse {
        return $this->sendResponse(
            new Command(
                'go',
                $request->direction
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function take(Request $request): JsonResponse {
        return $this->sendResponse(
            new Command(
                'take',
                $request->item
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function interact(Request $request): JsonResponse {
        return $this->sendResponse(
            new Command(
                'interact',
                $request->with,
                $request->all(),
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function claim(Request $request): JsonResponse {
        return $this->sendResponse(
            new Command(
                'claim',
            )
        );
    }
}
