<?php

namespace App\Domain\Quest\Factories;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\Player;
use App\Models\Quest;
use Illuminate\Support\Str;

/**
 * Class QuestResolverFactory
 */
class QuestResolverFactory
{
    public function __invoke(string $subject): Quest|null
    {
        $class = "App\Domain\Quest\Resolvers\\".Str::of($subject)->camel()->ucfirst().'QuestResolver';
        if (class_exists($class)) {
            $resolver = new $class;
            return Quest::where('quest', $class)->first();
        }
        return null;
    }
}
