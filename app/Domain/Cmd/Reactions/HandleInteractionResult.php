<?php

namespace App\Domain\Cmd\Reactions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Inventory\Handler\FindInventoryItems;
use App\Domain\Map\Position;
use App\Game\Cmd\Command;
use App\Models\InventoryItem;
use App\Models\Item;
use App\Models\MapFieldItem;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Arr;

class HandleInteractionResult
{
    /**
     * @param Item $item
     * @param Command $command
     * @return ActionResult
     */
    public static function handle(Item $item, Command $command): ActionResult
    {

        $player = $command->player;
        $mapField = $player->mapField;

        if (!$item->interactable) {
            return new ActionResult(
                false,
                "Can't interact with " . $command->subject . ".",
                "can-not-interact-with-item"
            );
        }

        $requiredItemKeys = $item->requires->pluck('key')->flatten();

        foreach ($requiredItemKeys as $requiredItemKey) {
            if (!in_array($requiredItemKey, $command->data['using'])) {
                return new ActionResult(
                    false,
                    "Can't interact with this because the correct tools have to be defined.",
                    "can-not-interact-tool-has-to-be-defined"
                );
            }
        }

        // Check if the tools is in the players inventory
        /** @todo query in a loop, refactor */
        foreach ($requiredItemKeys as $requiredItemKey) {
            $inventoryItem = (new FindInventoryItems)(
                $requiredItemKey,
                $command->player
            )->first();
            if (!$inventoryItem) {
                return new ActionResult(
                    false,
                    "Can't interact with this because the appropriate tools are missing.",
                    "can-not-interact-tool-missing-in-inventory",
                    [
                        'player_id' => $command->player->id
                    ]
                );
            }
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

        foreach ($item->produces as $producesItem) {
            MapFieldItem::create(
                [
                    'map_field_id' => $mapField->id,
                    'item_id' => $producesItem->id
                ]);
        }

        return new ActionResult(
            true,
            "Interacted successfully with:",
            "interacted-with",
            [
                'item' => $command->subject
            ]
        );
    }

    public static function failed()
    {
        return new ActionResult(
            true,
            "Can't interact with this.",
            "can-not-interact"
        );
    }
}
