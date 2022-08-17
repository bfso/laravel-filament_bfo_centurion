<?php

namespace App\Game\Factories;

use App\Game\Actions\BuildAction;
use App\Game\Actions\EatAction;
use App\Game\Actions\CraftAction;
use App\Game\Actions\NoAction;
use App\Game\Actions\TakeAction;
use App\Game\Actions\LookAction;
use App\Game\Actions\GoAction;
use App\Game\Cmd\Command;
use App\Http\Controllers\Api\CmdController;

class ActionFactory {
    public static function create(Command $command) {
        if($command->scope == "App\Http\Livewire\Inventory"){
            if($command->action == "eat"){
                return new EatAction($command);
            }
            if($command->action == "craft"){
                return new CraftAction($command);
            }
            if($command->action == "build"){
                return new BuildAction($command);
            }
        }

        if($command->scope == "App\Http\Livewire\Cmd" || $command->scope == CmdController::class){
            if($command->action == "take"){
                return new TakeAction($command);
            }
            if($command->action == "look"){
                return new LookAction($command);
            }
            if($command->action == "go" ){
                return new GoAction($command);
            }
        }

        if($command->scope == "App\Http\Livewire\Map"){
            if($command->action == "take"){
                return new TakeAction($command);
            }
            if($command->action == "go" ){
                return new GoAction($command);
            }
        }

        return new NoAction($command);
    }
}
