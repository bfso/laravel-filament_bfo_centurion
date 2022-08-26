<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use Illuminate\Http\Request;

class CmdController extends CommandController {
    public function look(Request $request) {
        return $this->sendResponse(
            new Command(
                'look'
            )
        );
    }

    public function go(Request $request) {
        return $this->sendResponse(
            new Command(
                'go',
                $request->direction
            )
        );
    }

    public function take(Request $request) {
        return $this->sendResponse(
            new Command(
                'take',
                $request->item
            )
        );
    }
}
