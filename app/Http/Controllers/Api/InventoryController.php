<?php

namespace App\Http\Controllers\Api;

use App\Game\Cmd\Command;
use Illuminate\Http\Request;

class InventoryController extends CommandController {
    public function show(Request $request) {
        return $this->sendResponse(
            new Command(
                'show'
            )
        );
    }

    public function discard(Request $request) {
        return $this->sendResponse(
            new Command(
                'discard',
                $request->item
            )
        );
    }

    public function craft(Request $request) {
        //return response()->json($request->item, 200);
        return $this->sendResponse(
            new Command(
                'craft',
                $request->item,
                $request->all(),
            )
        );
    }

    public function eat(Request $request) {
        //return response()->json($request->item, 200);
        return $this->sendResponse(
            new Command(
                'eat',
                $request->item
            )
        );
    }
}
