<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceChangePartnerResource\Pages;
use App\Models\DeviceChangePartner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\DeviceChangePartnerResource\RelationManagers\DeviceChangeRelationManager;
use App\Filament\Resources\DeviceChangePartnerResource\RelationManagers\DeviceRelationManager;

use Filament\Forms\Components\FileUpload;

class DeviceChangePartnerResource extends Resource
{
    protected static ?string $model = DeviceChangePartner::class;
    protected static ?string $navigationGroup = 'Personal';
    protected static ?string $modelLabel = 'Entrega o Mejora';
    protected static ?string $pluralModelLabel = 'Entregas o Mejoras';
    protected static ?string $navigationIcon = 'heroicon-m-arrows-up-down';
    protected static ?int $navigationSort = 1;

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
                // Campo Tipo de Cambio
                Forms\Components\Select::make('type')
                    ->options(['Entrega' => 'Entrega', 'Mejora' => 'Mejora'])
                    ->required()
                    ->searchable()
                    ->translateLabel(),
                // Campo Computadora
                // Forms\Components\Select::make('device_id')
                //     ->label('Dispositivo')
                //     ->options(function (Get $get) {
                //         $partner = Partner::find($get('partner_id'));

                //         if ($partner) {
                //             $devices = $partner->devices;
                //             $options = $devices->pluck('name', 'id');
                //             return $options;
                //         } else {
                //             return collect();
                //         }
                //     })
                //     ->searchable()
                //     ->required()
                //     ->preload()
                //     ->multiple()
                //     ->translateLabel(),
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
                // Campo Device Change ID
                Forms\Components\Select::make('device_change_id')
                    ->label('Entregas o Mejoras')
                    ->relationship('device_change', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->disabled(),
                // Campo Devices 
                Forms\Components\Select::make('device_id')
                    ->label('Equipo Entregado o Mejorado')
                    ->relationship('devices', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->disabled(),

                // Campo Para Subir Reportes(PDF) Firmados
                FileUpload::make('attachment')
                    ->translateLabel()
                    ->columnSpan(2)
                    ->AcceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->preserveFilenames()
                    ->maxFiles(1)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Usuario
                Tables\Columns\TextColumn::make('partner.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Cambio en el Equipo
                Tables\Columns\TextColumn::make('device_change.name')
                    ->label('Entregas o Mejoras')
                    ->translateLabel()
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                // Columna Cambio en el Equipo
                Tables\Columns\TextColumn::make('devices.name')
                    ->label('Equipos')
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
                Tables\Filters\SelectFilter::make('replenishment')
                    ->options([
                        'Solicitado' => 'Solicitado',
                        'Pendiente' => 'Pendiente',
                        'N/A' => 'No Aplica',
                    ])
                    ->translateLabel(),

                Tables\Filters\TrashedFilter::make(),
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
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DeviceChangeRelationManager::class,
            DeviceRelationManager::class,
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
