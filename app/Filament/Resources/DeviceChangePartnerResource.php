<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceChangePartnerResource\Pages;
use App\Models\DeviceChangePartner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use App\Models\Partner;
use Filament\Forms\FormsComponent;

class DeviceChangePartnerResource extends Resource
{
    protected static ?string $model = DeviceChangePartner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('partner_id')
                    ->label('id user')
                    ->relationship('partner', 'name')
                    ->live()
                    ->required()
                    ->afterStateUpdated(function (callable $set) {
                        $set('device_id', null);
                    }),
                // Campo Device_ID
                Forms\Components\Select::make('device_change_id')
                    ->label('Entrega o Mejora')
                    ->relationship('device_change', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                // Campo Tipo de Cambio
                Forms\Components\Select::make('type')
                    ->options(['Entrega' => 'Entrega', 'Mejora' => 'Mejora'])
                    ->required()
                    ->searchable()
                    ->translateLabel(),
                // Campo Computadora
                Forms\Components\Select::make('device_id')
                    ->label('Dispositivo')
                    ->options(function (Get $get) {
                        $partner = Partner::find($get('partner_id'));

                        if ($partner) {
                            $devices = $partner->devices;
                            $options = $devices->pluck('name', 'id');
                            return $options;
                        } else {
                            return collect();
                        }
                    })
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Descripcion
                Forms\Components\Textarea::make('description')
                    ->maxLength('255')
                    ->translateLabel(),
                // Campo Reabastecimiento
                Forms\Components\Select::make('replenishment')
                    ->options(['Solicitado' => 'Solicitado', 'Pendiente' => 'Pendiente', 'N/A' => 'No Aplica'])
                    ->required()
                    ->searchable()
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('device.name')
                Tables\Columns\TextColumn::make('id')
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
            'index' => Pages\ListDeviceChangePartners::route('/'),
            'create' => Pages\CreateDeviceChangePartner::route('/create'),
            'edit' => Pages\EditDeviceChangePartner::route('/{record}/edit'),
        ];
    }
}
