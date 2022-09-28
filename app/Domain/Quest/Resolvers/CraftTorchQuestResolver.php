<?php

namespace App\Domain\Quest\Resolvers;

use App\Domain\Quest\Traits\Resolveable;
use App\Models\Inventory;
use App\Models\Player;
use App\Models\Quest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CraftTorchQuestResolver
{
    use Resolveable;

    protected Player|null $player = null;

    protected Collection|null $data = null;

    protected Quest|null $quest = null;

    public function title(): string
    {
        return 'Burn them!';
    }

    public function description(): string
    {
        return 'Craft a torch. Torches are usually made with wax';
    }

    public function key() : string
    {
        $className = get_class($this);
        $questKey = explode('\\', $className);
        $questKey = str_replace('QuestResolver', '', $questKey);
        $questKey = end($questKey);

        return Str::kebab($questKey);
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
        if ($this->data->count() > 0) {
            return true;
        }
        return false;
    }

    protected function payQuestCost() : void
    {
        // No quest costs needed
    }

    protected function reward() : void
    {
        $this->player->experience += $this->quest->experience;
        $this->player->save();
    }

    protected function rewardText(): string
    {
        return 'Congratulation! You received experience as a reward!';
    }
}
