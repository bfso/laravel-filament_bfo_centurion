<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use Illuminate\Http\Request;

class QuestController extends CommandController {
    public function index(Request $request) {
        return $this->sendResponse(
            new Command(
                'show-quests'
            )
        );
    }
    public function resolve(Request $request) {
        return $this->sendResponse(
            new Command(
                'resolve-quests',
                $request->quest
            )
        );
    }
}
