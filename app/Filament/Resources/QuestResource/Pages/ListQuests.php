<?php

namespace App\Filament\Resources\QuestResource\Pages;

use App\Filament\Resources\QuestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuests extends ListRecords
{
    protected static string $resource = QuestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
