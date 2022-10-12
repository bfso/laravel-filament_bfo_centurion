<?php

namespace App\Domain\Quest\Factories;

use App\Domain\Quest\Contracts\QuestResolver;
use Illuminate\Support\Str;

/**
 * Class QuestResolverFactory
 */
class QuestResolverFactory
{
    public function __invoke(string $subject): QuestResolver|null
    {
        $class = "App\Domain\Quest\Resolvers\\" . Str::of($subject)->camel()->ucfirst() . 'QuestResolver';
        return (class_exists($class)) ? new $class() : null;
    }
}
