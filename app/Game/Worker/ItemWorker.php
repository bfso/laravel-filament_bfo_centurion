<?php

namespace App\Game\Worker;

use App\Game\Actions\ActionResult;
use App\Game\Cmd\Command;

trait ItemWorker {

    protected $command = "";

    /**
     * Create a new job instance.
     *
     * @param Command $command
     */
    public function __construct(Command $command) {
        $this->command = $command;
    }

    /**
     * @param array $steps
     * @return ActionResult
     */
    protected function run(array $steps): ActionResult {
        $actionResult = null;
        foreach ($steps as $closure) {
            /** @var ActionResult $actionResult */
            $actionResult = $closure();
            if (!$actionResult->success) {
                return $actionResult;
            }
        }
        return $actionResult;
    }
}
