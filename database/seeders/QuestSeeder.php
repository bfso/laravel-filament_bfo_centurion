<?php

namespace Database\Seeders;

use App\Domain\Quest\Resolvers\FindApplesQuestResolver;
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
    }
}