<?php

namespace App\Domain\Quest\Resolvers;

use App\Domain\Quest\Traits\Resolveable;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Player;
use App\Models\Quest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\NotImplementedException;

class FindApplesQuestResolver {
    use Resolveable;

    const REQUIRED_COUNT = 3;

    protected Player|null $player = null;
    protected Collection|null $data = null;
    protected Quest|null $quest = null;

    public function title() {
        return 'Apple Jack';
    }

    public function description() {
        return 'Find ' . self::REQUIRED_COUNT . ' Apples';
    }

    public function key() {
        $className = get_class($this);
        $questKey = explode('\\', $className);
        $questKey = str_replace("QuestResolver", "", $questKey);
        $questKey = end($questKey);
        return Str::kebab($questKey);
    }

    protected function data() {
        return Inventory::where('player_id', $this->player->id)
            ->with('items', function($q) {
                $q->where('key', 'apple');
            })
            ->get()
            ->pluck('items')
            ->flatten()
            ->take(self::REQUIRED_COUNT);
    }

    public function isConditionMet() {
        if ($this->data == null) {
            $this->data = $this->data();
        }
        return $this->data->count() == self::REQUIRED_COUNT;
    }

    protected function payQuestCost() {
        $ids = $this->data->pluck('pivot.id');
        InventoryItem::whereIn('id', $ids)->delete();
    }

    protected function reward() {
        Inventory::where('player_id', $this->player->id)
            ->where('key', 'linen-bag')
            ->update(
                [
                    'key' => 'woolen-bag',
                    'slots' => 7,
                ]
            );
    }

    protected function rewardText(): string {
        return "Congratulation! You received a woolen bag as a reward!";
    }

}
