<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class InventoryController extends CommandController {
    public function show(Request $request) {
        return $this->do('show');
    }
    public function discard(Request $request) {
        return $this->do('discard ' . $request->item);
    }
}
