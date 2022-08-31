<?php

namespace App\Domain\Quest\Actions;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Game\Actions\BaseAction;
use App\Models\Inventory;
use App\Models\Player;
use App\Models\PlayerQuest;
use Illuminate\Support\Str;

/**
 * Class ShowAction
 * Shows the items of all inventories
 *
 * @package App\Game\Actions
 */
class ShowQuestsAction extends BaseAction {

    public function do() {
        /** @var Player $player */
        $player = $this
            ->command
            ->player;
        $quests = ($player->with('quests')->where('id', $player->id)->first())->quests;

        $quests->map(function($quest) {
            $questResolver = new $quest->quest();
            $quest->key = $questResolver->key();
            $quest->description = $questResolver->description();
            $quest->title = $questResolver->title();
            return $quest;
        });

        if ($quests->count() >= 1) {
            return new ActionResult(
                true,
                "You have the following quests:",
                "player-quest-list",
                [
                    'quests' => $quests
                ]
            );
        }
        return new ActionResult(
            true,
            "No quests found.",
            "no-player-quests"
        );
    }

}
