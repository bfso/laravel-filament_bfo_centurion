<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class QuestController extends CommandController {
    public function index(Request $request) {
        return $this->do('show-quests');
    }
    public function resolve(Request $request) {
        return $this->do('resolve-quests ' . $request->quest);
    }
}
