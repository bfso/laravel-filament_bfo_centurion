<?php

namespace App\Domain\Quest\Resolvers;

use App\Domain\Quest\Contracts\QuestResolver;
use App\Models\Inventory;

class CraftTorchQuestResolver extends BaseQuestResolver implements QuestResolver
{
    public function title(): string
    {
        return 'Burn them!';
    }

    public function description(): string
    {
        return 'Craft a torch. Torches are usually made with wax';
    }

    protected function data()
    {
        return Inventory::where('player_id', $this->player->id)
            ->with('items', function ($q) {
                $q->where('key', 'torch');
            })
            ->get()
            ->pluck('items')
            ->flatten();
    }

    public function isConditionMet() : bool
    {
        return $this->data->count() > 0;
    }

    protected function payQuestCost() : void
    {
        // No quest costs needed
    }

    protected function reward() : void
    {
        $this->player->experience += $this->playerQuest->quest->experience;
        $this->player->save();
    }

    protected function rewardText(): string
    {
        return 'Congratulation! You received experience as a reward!';
    }
}
