<?php

namespace App\Filament\Resources\DeviceChangePartnerResource\RelationManagers;

use App\Models\DeviceModel;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class DeviceChangeRelationManager extends RelationManager
{
    protected static string $relationship = 'device_change';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->translateLabel(),
                // Campo Marca
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->translateLabel()
                    ->afterStateUpdated(function (callable $set) {
                        $set('model_id', null);
                    }),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->label('Model')
                    ->options(fn (Get $get): Collection => DeviceModel::query()->where('brand_id', $get('brand_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (): Collection => Type::query()->where('device_type', 'others')->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Numero de Activo
                Forms\Components\TextInput::make('asset_number')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo Numero de Serie
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->translateLabel(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->wrap()
                    ->sortable(),
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->sortable()
                    ->translateLabel(),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->sortable()
                    ->translateLabel(),
                // Columna Tipo
                Tables\Columns\TextColumn::make('type.name')
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Activo
                Tables\Columns\TextColumn::make('asset_number')
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->sortable()
                    ->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make('device_change_partner')->preloadRecordSelect(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
