<?php

namespace App\Domain\Quest\Resolvers;

use App\Domain\Game\Actions\ActionResult;
use App\Domain\Quest\Contracts\QuestResolver;
use App\Models\Player;
use App\Models\PlayerQuest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class BaseQuestResolver implements QuestResolver {

    protected Player|null $player = null;

    protected Collection|null $data = null;

    protected PlayerQuest|null $playerQuest = null;

    public function resolve(Player $player): ActionResult {
        $this->player = $player;

        $this->loadPlayerQuest();

        if (!$this->isQuestOpen()) {
            return new ActionResult(
                false,
                'The quest is not open',
                'quest-not-open'
            );
        }

        $this->data = $this->data();

        if (!$this->isConditionMet()) {
            return new ActionResult(
                false,
                'The quests conditions are not met',
                'quest-conditions-not-met',
                [
                    'description' => $this->description(),
                ]
            );
        }
        $this->payQuestCost();
        $this->completeQuest();
        $this->reward();

        return new ActionResult(
            true,
            'Quest successfully resolved',
            'quest-resolved',
            [
                'reward_text' => $this->rewardText(),
            ]
        );
    }

    public function key(): string {
        $className = get_class($this);
        $questKey = explode('\\', $className);
        $questKey = str_replace('QuestResolver', '', $questKey);
        $questKey = end($questKey);

        return Str::kebab($questKey);
    }

    public function camelKey() {
        return Str::of($this->key())->camel()->ucfirst();
    }

    public function loadPlayerQuest() {
        $key = $this->camelKey();
        $this->playerQuest = PlayerQuest::query()
            ->with('quest')
            ->whereHas('quest', function($query) use ($key) {
                return $query
                    ->where('quest', 'LIKE', '%' . $key . '%');
            })
            ->where('player_id', $this->player->id)
            ->first();
    }

    public function isQuestOpen(): bool {
        if (!$this->playerQuest) {
            return false;
        }
        if (!$this->playerQuest->is_started) {
            return false;
        }
        if ($this->playerQuest->is_successful) {
            return false;
        }
        if ($this->playerQuest->is_failed) {
            return false;
        }

        return true;
    }

    protected function completeQuest(): void {
        PlayerQuest::where('player_id', $this->player->id)
            ->where('quest_id', $this->playerQuest->quest_id)
            ->update(['is_successful' => true]);
    }

    abstract function title();

    abstract function description();

    abstract protected function data();

    abstract function isConditionMet(): bool;

    abstract protected function payQuestCost();

    abstract protected function reward();

    abstract protected function rewardText(): string;
}
