<?php
    namespace App\Domain\Map\Worker;

    use App\Domain\Game\Actions\ActionResult;

    class ClaimMapField
    {
        public static function handle($action) : ActionResult
        {
            $action->mapField->guild_id = $action->guild->id;
            $action->mapField->save();

            return ActionResult::make('map-field-claimed')
                ->message('Map field claimed for : ' . $action->guild->name)
                ->data(
                    [
                        'guild' => $action->guild->toArray(),
                        'player' => $action->player->toArray(),
                        'position' => $action->mapField->position()->toArray(),
                    ],
                )
                ->success();
        }
    }
