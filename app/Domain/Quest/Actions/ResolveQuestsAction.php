<?php

namespace App\Domain\Quest\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Domain\Quest\Factories\QuestResolverFactory;

/**
 * Class ResolveQuestsAction
 * Shows the items of all inventories
 */
class ResolveQuestsAction extends BaseAction
{
    public function do(): ActionResult
    {
        $resolver = (new QuestResolverFactory)($this->getSubject());
        if($resolver){
            return $resolver->resolve($this->getPlayer());
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
