<?php

namespace Database\Seeders;

use App\Domain\Quest\Resolvers\CraftTorchQuestResolver;
use App\Domain\Quest\Resolvers\FindApplesQuestResolver;
use App\Models\Player;
use App\Models\Quest;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Quest::factory()->create(['is_active' => true, 'quest' => FindApplesQuestResolver::class]);
        Quest::factory()->create(['is_active' => true, 'quest' => CraftTorchQuestResolver::class, 'experience' => 40]);

        foreach (Quest::get() as $record){
            $record->players()->saveMany(Player::get());
        }
    }
}
