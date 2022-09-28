<?php

namespace App\Domain\Quest\Resolvers;

use App\Domain\Quest\Traits\Resolveable;
use App\Models\Player;
use App\Models\Quest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CraftTorchQuestResolver
{
    use Resolveable;

    const REQUIRED_COUNT = 3;

    protected Player|null $player = null;

    protected Collection|null $data = null;

    protected Quest|null $quest = null;

    public function title()
    {
        return 'Burn them!';
    }

    public function description()
    {
        return 'Craft a torch. Torches are usually made with wax';
    }

    public function key()
    {
        $className = get_class($this);
        $questKey = explode('\\', $className);
        $questKey = str_replace('QuestResolver', '', $questKey);
        $questKey = end($questKey);

        return Str::kebab($questKey);
    }

    protected function data()
    {
        return collect();
    }

    public function isConditionMet()
    {
        return true;
    }

    protected function payQuestCost()
    {
    }

    protected function reward()
    {
        $this->player->experience += $this->quest->experience;
        $this->player->save();
    }

    protected function rewardText(): string
    {
        return 'Congratulation! You received a experience as a reward!';
    }
}
