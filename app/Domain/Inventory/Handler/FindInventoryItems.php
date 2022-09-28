<?php

namespace App\Domain\Inventory\Handler;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Builder;

class FindInventoryItems
{
    public function __invoke($itemKey, $player): Builder
    {
        return InventoryItem::with(['item', 'inventory'])
            ->whereHas('item', function ($query) use ($itemKey) {
                return $query->where('key', $itemKey);
            })->whereHas('inventory', function ($query) use ($player) {
                return $query->where('player_id', $player->id);
            });
    }
}
