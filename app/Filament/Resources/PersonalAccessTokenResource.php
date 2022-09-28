<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalAccessTokenResource\Pages;
use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenResource extends Resource
{
    protected static ?string $model = PersonalAccessToken::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $query->where('tokenable_id', auth()->user()->id);

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tokenable_id')->getStateUsing(
                    function ($record) {
                        return User::where('id', $record->tokenable_id)->first()->name;
                    }
                )->label('user'),
                Tables\Columns\TextColumn::make('token'),
            ])
            ->filters([
                //
            ])
            ->appendHeaderActions([
                Tables\Actions\Action::make('Generate New Token')->action(function () {
                    $token = auth()->user()->createToken(self::generateRandomString());
                })->button()->color('primary'),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    private static function generateRandomString($length = 5)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            ceil($length / strlen($x)))), 1, $length);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersonalAccessTokens::route('/'),
            'create' => Pages\CreatePersonalAccessToken::route('/create'),
            'edit' => Pages\EditPersonalAccessToken::route('/{record}/edit'),
        ];
    }
}
