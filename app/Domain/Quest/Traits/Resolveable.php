<?php

namespace App\Domain\Quest\Traits;

use App\Domain\Game\Actions\ActionResult;
use App\Models\Player;
use App\Models\PlayerQuest;
use App\Models\Quest;
use Nette\NotImplementedException;

trait Resolveable {
    public function resolve(Player $player, Quest $quest) {
        $this->player = $player;
        $this->quest = $quest;
        $this->data = $this->data();
        if (!$this->isQuestOpen()) {
            return new ActionResult(
                false,
                'The quest is not open',
                "quest-not-open"
            );
        }
        if (!$this->isConditionMet()) {
            return new ActionResult(
                false,
                'The quests conditions are not met',
                "quest-conditions-not-met",
                [
                    'description' => $this->description()
                ]
            );
        }
        $this->payQuestCost();
        $this->completeQuest();
        $this->reward();

        return new ActionResult(
            true,
            'Quest successfully resolved',
            "quest-resolved",
            [
                'reward_text' => $this->rewardText()
            ]
        );
    }

    public function isQuestOpen() {
        $playerQuest = PlayerQuest::where('player_id', $this->player->id)
            ->where('quest_id', $this->quest->id)
            ->first();
        if (!$playerQuest) {
            return false;
        }
        if (!$playerQuest->is_started) {
            return false;
        }
        if ($playerQuest->is_successful) {
            return false;
        }
        if ($playerQuest->is_failed) {
            return false;
        }
        return true;
    }

    protected function completeQuest() {
        PlayerQuest::where('player_id', $this->player->id)
            ->where('quest_id', $this->quest->id)
            ->update(['is_successful' => true]);
    }

    public function title() {
        throw new NotImplementedException;
    }

    public function description(): string {
        throw new NotImplementedException;
    }

    protected function data() {
        throw new NotImplementedException;
    }
    public function isConditionMet(): bool {
        throw new NotImplementedException;
    }

    protected function payQuestCost() {
        throw new NotImplementedException;
    }

    protected function reward() {
        throw new NotImplementedException;
    }

    protected function rewardText(): string {
        throw new NotImplementedException;
    }
}
