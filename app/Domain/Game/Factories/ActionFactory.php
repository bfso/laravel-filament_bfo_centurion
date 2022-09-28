<?php

namespace App\Domain\Game\Factories;

use App\Domain\Cmd\Actions\GoAction;
use App\Domain\Cmd\Actions\InteractAction;
use App\Domain\Cmd\Actions\LookAction;
use App\Domain\Cmd\Actions\TakeAction;
use App\Domain\EventMessages\Actions\ShowEventMessagesAction;
use App\Domain\Game\Actions\NoAction;
use App\Domain\Inventory\Actions\CraftAction;
use App\Domain\Inventory\Actions\DiscardAction;
use App\Domain\Inventory\Actions\EatAction;
use App\Domain\Inventory\Actions\ShowAction;
use App\Domain\Map\Actions\BuildAction;
use App\Domain\Quest\Actions\ResolveQuestsAction;
use App\Domain\Quest\Actions\ShowQuestsAction;
use App\Game\Cmd\Command;

class ActionFactory
{
    public static function create(Command $command)
    {
        if ($command->action == 'show') {
            return new ShowAction($command);
        }
        if ($command->action == 'discard') {
            return new DiscardAction($command);
        }
        if ($command->action == 'eat') {
            return new EatAction($command);
        }
        if ($command->action == 'craft') {
            return new CraftAction($command);
        }
        if ($command->action == 'build') {
            return new BuildAction($command);
        }
        if ($command->action == 'take') {
            return new TakeAction($command);
        }
        if ($command->action == 'look') {
            return new LookAction($command);
        }
        if ($command->action == 'interact') {
            return new InteractAction($command);
        }
        if ($command->action == 'go') {
            return new GoAction($command);
        }
        if ($command->action == 'show-quests') {
            return new ShowQuestsAction($command);
        }
        if ($command->action == 'resolve-quests') {
            return new ResolveQuestsAction($command);
        }
        if ($command->action == 'show-event-messages') {
            return new ShowEventMessagesAction($command);
        }

        return new NoAction($command);
    }
}
