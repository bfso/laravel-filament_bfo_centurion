<?php

namespace App\Domain\Cmd\Reactions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Map\Position;
use App\Game\Cmd\Command;
use App\Models\InventoryItem;
use App\Models\Item;
use App\Models\MapFieldItem;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Arr;

class HandleInteractionResult {
    /**
     * @param Item $item
     * @param Command $command
     * @return ActionResult
     */
    public static function handle(Item $item, Command $command): ActionResult {
        $player = $command->player;
        $mapField = $player->mapField;

        if ($command->subject != 'bee-hive') {
            return new ActionResult(
                false,
                "Can't interact with this because the item " . $command->subject . " is missing.",
                "can-not-interact-with-item"
            );
        }

        if ($command->data['using'][0] != 'spear') {
            return new ActionResult(
                false,
                "Can't interact with this because an appropriate tool is needed.",
                "can-not-interact-need-a-tool"
            );
        }

        $spearInInventory = InventoryItem::with(['item', 'inventory'])
            ->whereHas('inventory', function($query) use ($command) {
                return $query->where('player_id', $command->player->id);
            })
            ->whereHas('item', function($query) {
                return $query->where('key', 'spear');
            })->first();

        if (!$spearInInventory) {
            return new ActionResult(
                false,
                "Can't interact with this because the appropriate tool is missing.",
                "can-not-interact-tool-missing",
                [
                    'player_id' => $command->player->id
                ]
            );
        }

        $mapFieldItem = MapFieldItem::where('item_id', $item->id)->where('map_field_id', $mapField->id)->first();
        if (!$mapFieldItem) {
            return new ActionResult(
                false,
                "Can't interact with this because the item " . $command->subject . " is missing.",
                "can-not-interact-item-missing"
            );
        }
        $mapFieldItem->delete();

        $wax = Item::where('key', 'wax')->first();
        $honey = Item::where('key', 'honey')->first();

        MapFieldItem::create(
            [
                'map_field_id' => $mapField->id,
                'item_id' => $wax->id
            ]);

        MapFieldItem::create(
            [
                'map_field_id' => $mapField->id,
                'item_id' => $honey->id
            ]);

        return new ActionResult(
            true,
            "Interacted successfully with:",
            "interacted-with",
            [
                'item' => $command->subject
            ]
        );

    }

    public static function failed() {
        return new ActionResult(
            true,
            "Can't interact with this.",
            "can-not-interact"
        );
    }
}
