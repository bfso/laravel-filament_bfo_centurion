<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use Illuminate\Http\Request;

class EventMessageController extends CommandController {
    public function index(Request $request) {
        return $this->sendResponse(
            new Command(
                'show-event-messages'
            )
        );
    }
}
