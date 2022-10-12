<?php

namespace App\Domain\Game\Factories;

use App\Domain\Cmd\Actions\GoAction;
use App\Domain\Cmd\Actions\InteractAction;
use App\Domain\Cmd\Actions\LookAction;
use App\Domain\Cmd\Actions\TakeAction;
use App\Domain\EventMessages\Actions\ShowEventMessagesAction;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Game\Actions\NoAction;
use App\Domain\Inventory\Actions\CraftAction;
use App\Domain\Inventory\Actions\DiscardAction;
use App\Domain\Inventory\Actions\EatAction;
use App\Domain\Inventory\Actions\ShowAction;
use App\Domain\Map\Actions\BuildAction;
use App\Domain\Quest\Actions\ResolveQuestsAction;
use App\Domain\Quest\Actions\ShowQuestsAction;
use App\Game\Cmd\Command;

class ActionFactory {
    public static function create(Command $command): BaseAction {
        return match ($command->action) {
            'show' => new ShowAction($command),
            'discard' => new DiscardAction($command),
            'eat' => new EatAction($command),
            'craft' => new CraftAction($command),
            'build' => new BuildAction($command),
            'take' => new TakeAction($command),
            'look' => new LookAction($command),
            'interact' => new InteractAction($command),
            'go' => new GoAction($command),
            'show-quests' => new ShowQuestsAction($command),
            'resolve-quests' => new ResolveQuestsAction($command),
            'show-event-messages' => new ShowEventMessagesAction($command),
            default => new NoAction($command),
        };
    }
}
