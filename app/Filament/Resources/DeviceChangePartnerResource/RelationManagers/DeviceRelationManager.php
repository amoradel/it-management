<?php

namespace App\Filament\Resources\DeviceChangePartnerResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DeviceRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ubicacion
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Any Desk
                Tables\Columns\TextColumn::make('anydesk')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ip
                Tables\Columns\TextColumn::make('ip.ip_address')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Marca
                // Tables\Columns\TextColumn::make('brand.name')
                //     ->searchable()
                //     ->sortable()
                //     ->translateLabel(),
                // // Columna Modelo
                // Tables\Columns\TextColumn::make('model.name')
                //     ->searchable()
                //     ->sortable()
                //     ->translateLabel(),
                // // Columna Tipo
                // Tables\Columns\TextColumn::make('type.name')
                //     ->searchable()
                //     ->sortable()
                //     ->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make('devices')

                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
