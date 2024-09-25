<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestResource\Pages;
use App\Filament\Resources\QuestResource\RelationManagers;
use App\Models\Guild;
use App\Models\Player;
use App\Models\Quest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\QueryException;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BooleanColumn::make('is_active'),
                Tables\Columns\TextColumn::make('quest'),
                Tables\Columns\TextColumn::make('title')->getStateUsing(
                    function ($record) {
                        $quest = new $record->quest();

                        return $quest->title();
                    }
                ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('assign_to_all')
                    ->action(function ($record) {
                        try {
                            $record->players()->saveMany(Player::get());
                        } catch (QueryException $e) {
                            $errorCode = $e->errorInfo[1];
                            if ($errorCode == 1062) {
                                // houston, we have a duplicate entry problem
                            }
                        }
                    })
                    ->button()
                    ->color('gray'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PlayerRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuests::route('/'),
            'create' => Pages\CreateQuest::route('/create'),
            'edit' => Pages\EditQuest::route('/{record}/edit'),
        ];
    }
}
