<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceChangeResource\Pages;
use App\Filament\Resources\DeviceChangeResource\RelationManagers;
use App\Models\DeviceChange;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceChangeResource extends Resource
{
    protected static ?string $model = DeviceChange::class;
    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Equipo o Pieza';
    protected static ?string $pluralModelLabel = 'Equipos o Piezas';

    protected static ?string $navigationIcon = 'heroicon-m-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->translateLabel()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListDeviceChanges::route('/'),
            'create' => Pages\CreateDeviceChange::route('/create'),
            'edit' => Pages\EditDeviceChange::route('/{record}/edit'),
        ];
    }
}
