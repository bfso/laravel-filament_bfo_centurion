<?php

namespace App\Domain\Map\Jobs;

use App\Domain\Game\Actions\Action;
use App\Domain\Game\Actions\ActionResult;
use App\Domain\Guild\Checks\GuildExistsCheck;
use App\Domain\Map\Actions\ClaimAction;
use App\Domain\Map\Checks\MapFieldExistsCheck;
use App\Domain\Map\Events\ClaimingFinished;
use App\Domain\Map\Worker\ClaimMapField;
use App\Models\Guild;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class Claim implements ShouldQueue, ShouldBeUnique {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ClaimAction|null $action = null;

    public function __construct(ClaimAction $action)
    {
        $this->action = $action;
        $this->action->mapField = $this->action->player->mapField;
        $this->action->guild = Guild::where('name',$this->action->data['guild-name'])->firstOrFail();
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle() {

        $actionResult = $this->run(
            $this->action,
            [
                function($action) {
                    return MapFieldExistsCheck::handle($action);
                },
                function($action) {
                    return GuildExistsCheck::handle($action);
                },
                //function($item) {
                //    return LevelMismatchCheck::handle($mapField, $this->command);
                //},
                function($action) {
                    return ClaimMapField::handle($action);
                },
            ]
        );

        ClaimingFinished::dispatch($actionResult, $this->action->player, $this->action->mapField);
    }

    /**
     * @param Action $action
     * @param array $steps
     * @return ActionResult
     */
    protected function run(Action $action, array $steps): ActionResult
    {
        $actionResult = null;
        foreach ($steps as $closure) {
            /** @var ActionResult $actionResult */
            $actionResult = $closure($action);
            if (! $actionResult->success) {
                return $actionResult;
            }
        }

        return $actionResult;
    }
}
