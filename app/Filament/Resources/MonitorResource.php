<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitorResource\Pages;
use App\Filament\Resources\MonitorResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonitorResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $modelLabel = 'Monitor';
    protected static ?string $pluralModelLabel = "Monitores";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo Marca
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->translateLabel(),
                // Campo Ubicacion
                Forms\Components\TextInput::make('ubication')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->relationship('model', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->translateLabel(),
                // Campo Numero de Serie
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->relationship('type', 'name')
                    ->default('Monitor')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Numero de Activo
                Forms\Components\TextInput::make('asset_number')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo Observacion
                Forms\Components\TextInput::make('observation')
                    ->required()
                    ->translateLabel(),
                // Campo Condicion
                Forms\Components\Select::make('condition')
                    ->options((['Viejo' => 'Viejo', 'Nuevo' => 'Nuevo']))
                    ->required()
                    ->translateLabel(),
                // Campo Fecha de Ingreso
                Forms\Components\DatePicker::make('entry_date')
                    ->required()
                    ->maxDate(now())
                    ->translateLabel(),
                // Campo Estado
                Forms\Components\Toggle::make('status')
                    ->onColor('success')
                    ->default('true')
                    ->translateLabel(),
                // Columna que envia el tipo de equipo igual a computer
                Forms\Components\Hidden::make('device_type')
                    ->default('monitor'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Tipo
                Tables\Columns\TextColumn::make('type.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ubicacion
                Tables\Columns\TextColumn::make('ubication')
                    ->translateLabel(),
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Asset
                Tables\Columns\TextColumn::make('asset_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Condicion
                Tables\Columns\TextColumn::make('condition')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Fecha de entrada
                Tables\Columns\TextColumn::make('entry_date')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Observacion
                Tables\Columns\TextColumn::make('observation')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Estado
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->onColor('success'),
            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')->query(fn (Builder $query): Builder => $query->where('device_type', 'monitor'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListMonitors::route('/'),
            'create' => Pages\CreateMonitor::route('/create'),
            'edit' => Pages\EditMonitor::route('/{record}/edit'),
        ];
    }
}
