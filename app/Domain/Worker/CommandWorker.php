<?php

namespace App\Domain\Worker;

use App\Domain\Game\Actions\ActionResult;
use App\Game\Cmd\Command;

trait CommandWorker
{
    /**
     * @var Command
     */
    protected Command $command;

    /**
     * Create a new job instance.
     *
     * @param  Command  $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @param $item
     * @param array $steps
     * @return ActionResult
     */
    protected function run($item, array $steps): ActionResult
    {
        $actionResult = null;
        foreach ($steps as $closure) {
            /** @var ActionResult $actionResult */
            $actionResult = $closure($item);
            if (! $actionResult->success) {
                return $actionResult;
            }
        }

        return $actionResult;
    }
}
