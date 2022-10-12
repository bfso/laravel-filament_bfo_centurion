<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use Illuminate\Http\Request;

class PlayerController extends CommandController
{
    public function show(Request $request)
    {
        return $this->sendResponse(
            new Command(
                'show-player'
            )
        );
    }
}
