<?php

namespace App\Domain\Quest\Resolvers;

use App\Domain\Quest\Contracts\QuestResolver;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Player;
use App\Models\PlayerQuest;
use Illuminate\Support\Collection;

class FindApplesQuestResolver extends BaseQuestResolver implements QuestResolver
{
    const REQUIRED_COUNT = 3;

    protected Player|null $player = null;

    protected Collection|null $data = null;

    protected PlayerQuest|null $playerQuest = null;

    public function title(): string
    {
        return 'Apple Jack';
    }

    public function description(): string
    {
        return 'Find '.self::REQUIRED_COUNT.' Apples';
    }

    protected function data()
    {
        return Inventory::where('player_id', $this->player->id)
            ->with('items', function ($q) {
                $q->where('key', 'apple');
            })
            ->get()
            ->pluck('items')
            ->flatten()
            ->take(self::REQUIRED_COUNT);
    }

    public function isConditionMet(): bool
    {
        return $this->data->count() == self::REQUIRED_COUNT;
    }

    protected function payQuestCost(): void
    {
        $ids = $this->data->pluck('pivot.id');
        InventoryItem::whereIn('id', $ids)->delete();
    }

    protected function reward(): void
    {
        Inventory::where('player_id', $this->player->id)
            ->where('key', 'linen-bag')
            ->update(
                [
                    'key' => 'woolen-bag',
                    'slots' => 7,
                ]
            );
    }

    protected function rewardText(): string
    {
        return 'Congratulation! You received a woolen bag as a reward!';
    }
}
