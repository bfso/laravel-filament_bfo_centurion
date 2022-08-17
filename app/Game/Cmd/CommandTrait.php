<?php

namespace App\Game\Cmd;

use App\Game\Factories\ActionFactory;
use App\Models\Player;

trait CommandTrait
{
    public $command = "";
    public $suggestedCommands = null;
    public $commandHistory = [];
    public $commandHistoryPointer = 0;
    protected $actionResult = null;
    protected $commandObject = null;

    public function enter(){
        if ($this->command == "exit") {
            return redirect()->to('cmd');
        }
        if ($this->command == "bag") {
            return redirect()->to('inventory');
        }
        if ($this->command == "map") {
            return redirect()->to('map');
        }

        $commandObject = new Command(
            $this->command,
            get_class($this),
            Player::with(['mapField.items'])->first()
        );
        $this->actionResult = (ActionFactory::create($commandObject))->do();

        $this->addToHistory($this->command);
        if($this->actionResult->success){
            $this->command = "";
        }

        return null;
    }

    public function tab() {
        $suggested = $this->suggest();
        $this->command = $suggested->first();
        if($suggested->count() == 1){
            $this->enter();
        }
    }

    public function arrowDown(){
        if(empty($this->commandHistory)){
            return null;
        }
        if($this->commandHistoryPointer == 4){
            return null;
        }
        $this->commandHistoryPointer++;
        if(!isset($this->commandHistory[$this->commandHistoryPointer])){
            return null;
        }
        $this->command = $this->commandHistory[$this->commandHistoryPointer];
    }

    public function arrowUp(){
        if(empty($this->commandHistory)){
            return null;
        }
        if($this->commandHistoryPointer == 0){
            return null;
        }
        $this->commandHistoryPointer--;
        if(!isset($this->commandHistory[$this->commandHistoryPointer])){
            return null;
        }
        $this->command = $this->commandHistory[$this->commandHistoryPointer];
    }

    protected function addToHistory($command){
        $this->commandHistory[] = $command;
        if(count($this->commandHistory)>5){
            unset($this->commandHistory[0]);
            $this->commandHistory = array_values($this->commandHistory);
        }
    }

    protected function suggest(){
        $suggested = collect();
        $command = $this->command;
        if ($command) {
            $suggested = collect($this->suggestedCommands)->filter(function($item) use ($command) {
                return stripos($item, $command) !== false;
            });
        }
        return $suggested;
    }
}
