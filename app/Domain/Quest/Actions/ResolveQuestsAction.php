<?php

namespace App\Domain\Quest\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\Player;
use App\Models\Quest;
use Illuminate\Support\Str;

/**
 * Class ShowAction
 * Shows the items of all inventories
 */
class ResolveQuestsAction extends BaseAction
{
    public function do()
    {
        /** @var Player $player */
        $player = $this
            ->command
            ->player;

        $class = "App\Domain\Quest\Resolvers\\".Str::of($this->command->subject)->camel()->ucfirst().'QuestResolver';
        if (class_exists($class)) {
            $resolver = new $class;
            $quest = Quest::where('quest', $class)->first();

            return $resolver->resolve($player, $quest);
        }

        return new ActionResult(
            false,
            'No quest resolver found.',
            'no-quest-resolver-found',
            [
                'key' => $this->command->subject,
            ]
        );
    }
}
