<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class CmdController extends CommandController {
    public function look(Request $request) {
        return $this->do('look');
    }

    public function go(Request $request) {
        return $this->do('go ' . $request->direction);
    }

}
