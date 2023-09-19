<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IpResource\Pages;
use App\Filament\Resources\IpResource\RelationManagers;
use App\Models\Ip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IpResource extends Resource
{
    protected static ?string $model = Ip::class;

    protected static ?string $modelLabel = 'Ip';
    protected static ?string $pluralModelLabel = "Ip's";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Ip Number
                Forms\Components\TextInput::make('ip_number')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo Equipo
                Forms\Components\Select::make('device_id')
                    ->relationship('device', 'name')
                    ->searchable()
                    ->preload()
                    ->translateLabel(),
                // Campo Descripcion
                Forms\Components\Textarea::make('description')
                    ->translateLabel(),
                // Campo Tipo de Ip
                Forms\Components\Select::make('ip_type')
                    ->options(['Estática' => 'Estática', 'Dinámica' => 'Dinámica'])
                    ->required()
                    ->translateLabel(),
                // Campo Segmento
                Forms\Components\TextInput::make('segment')
                    ->required()
                    ->translateLabel(),
                // Campo Estado
                Forms\Components\Toggle::make('status')
                    ->onColor('success')
                    ->default('true')
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('ip_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Nombre
                Tables\Columns\TextColumn::make('device.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Tipo de Ip
                Tables\Columns\TextColumn::make('ip_type')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Descripcion
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Disponibilidad
                Tables\Columns\TextColumn::make('disponibility')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Segmento
                Tables\Columns\TextColumn::make('segment')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Estado
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->onColor('success'),
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
            'index' => Pages\ListIps::route('/'),
            'create' => Pages\CreateIp::route('/create'),
            'edit' => Pages\EditIp::route('/{record}/edit'),
        ];
    }
}
