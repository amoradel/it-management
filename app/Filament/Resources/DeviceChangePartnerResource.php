<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceChangePartnerResource\Pages;
use App\Models\DeviceChangePartner;
use App\Models\Type;
use App\Models\Device_model;
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
use Illuminate\Support\Collection;

class DeviceChangePartnerResource extends Resource
{
    protected static ?string $model = DeviceChangePartner::class;
    protected static ?string $navigationGroup = 'Personal';
    protected static ?string $modelLabel = 'Entrega o Mejora';
    protected static ?string $pluralModelLabel = 'Entregas o Mejoras';
    protected static ?string $navigationIcon = 'heroicon-m-arrows-up-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('partner_id')
                    ->label('Usuario')
                    ->relationship('partner', 'name')
                    ->preload()
                    ->searchable()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function (callable $set) {
                        $set('device_id', null);
                    }),
                // Campo Device_ID
                Forms\Components\Select::make('device_change_id')
                    ->label('Entrega o Mejora')
                    ->relationship('device_change', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        // Campo Nombre de la Pieza
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
                                $set('type_id', null);
                            }),
                        // Campo Modelo
                        Forms\Components\Select::make('model_id')
                            ->label('Model')
                            ->options(fn (Get $get): Collection => Device_model::query()->where('brand_id', $get('brand_id'))->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->translateLabel()
                            ->afterStateUpdated(function (callable $set) {
                                $set('type_id', null);
                            }),
                        // Campo Tipo
                        Forms\Components\Select::make('type_id')
                            ->label('Type')
                            ->options(fn (Get $get): Collection => Type::query()->where('model_id', $get('model_id'))->pluck('name', 'id'))
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
                    ]),
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
                // Columna Nombre del Equipo
                Tables\Columns\TextColumn::make('device.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Usuario
                Tables\Columns\TextColumn::make('partner.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Cambio en el Equipo
                Tables\Columns\TextColumn::make('device_change.name')
                    ->translateLabel()
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                // Columna Tipo
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Reabastecimiento
                Tables\Columns\TextColumn::make('replenishment')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Descripcion
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->translateLabel()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->icon('heroicon-s-document-arrow-down')
                    ->color('info')
                    ->url(fn (DeviceChangePartner $records) => route('download_pdf', $records))
                    ->openUrlInNewTab(),
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
