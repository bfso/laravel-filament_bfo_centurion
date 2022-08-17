<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Item;
use App\Models\MapField;
use App\Models\MapFieldItem;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Items
        $wood = Item::factory()->create(['key' => 'wood', 'takeable' => true]);
        $reed = Item::factory()->create(['key' => 'reed', 'takeable' => true]);
        $farm = Item::factory()->create(['key' => 'map', 'craftable' => true]);
        $farm->blueprints()->attach($wood);
        $farm->blueprints()->attach($reed);

        $waypoint = Item::factory()->create(['key' => 'waypoint', 'buildable' => true, 'level' => 2]);
        $waypoint->blueprints()->attach($wood);

        Item::factory(3)
            ->state(new Sequence(
                ['key' => 'tree'],
                ['key' => 'apple', 'eatable' => true, 'takeable' => true],
                ['key' => 'map', 'craftable' => true],
            ))
            ->create();

        // Blueprints


        // Map Fields
        for ($y = 0; $y <= 10; $y++) {
            for ($x = 0; $x <= 10; $x++) {
                $mapField = MapField::factory()->create(
                    [
                        'x' => $x,
                        'y' => $y,
                    ]
                );
                MapFieldItem::factory(rand(1,3))
                    ->state(new Sequence(
                        [
                            'map_field_id' => $mapField->id,
                            'item_id' => Item::where('takeable',true)->inRandomOrder()->first(),
                        ],
                        [
                            'map_field_id' => $mapField->id,
                            'item_id' => Item::where('takeable',true)->inRandomOrder()->first(),
                        ],
                        [
                            'map_field_id' => $mapField->id,
                            'item_id' => Item::where('takeable',true)->inRandomOrder()->first(),
                        ],
                    ))
                    ->create();
            }
        }

        // Players
        $playerMapField = MapField::inRandomOrder()->first();
        Player::factory(2)
            ->state(new Sequence(
                [
                    'name' => 'player1',
                    'map_field_id' => $playerMapField,
                    'user_id' => 1,
                ],
                [
                    'name' => 'player2',
                    'map_field_id' => $playerMapField,
                    'user_id' => 2,
                ],
            ))
            ->create();
    }
}
