<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CamerasDVRResource\Pages;
use App\Models\Device;
use App\Models\Device_model;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CamerasDvrResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Cámara o DVR';

    protected static ?string $pluralModelLabel = "Cámaras y DVR'S";

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignorable: fn ($record) => $record)
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
                // Campo Ubicacion
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(50)
                    ->translateLabel(),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->label('Model')
                    ->options(fn (Get $get): Collection => Device_model::query()
                        ->where('brand_id', $get('brand_id'))
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->translateLabel(),
                // Campo Programa
                Forms\Components\Select::make('dvr_program')
                    ->options(['IVMS-4200' => 'IVMS-4200', 'CMS3.0' => 'CMS3.0', 'VI MonitorPlus' => 'VI MonitorPlus'])
                    ->searchable()
                    ->preload()
                    ->translateLabel(),
                // Campo Tipo de Equipo
                Forms\Components\Select::make('device_type')
                    ->label('Camara/Dvr')
                    ->options(['camera' => 'Camara', 'dvr' => 'Dvr'])
                    ->required()
                    ->searchable()
                    ->live(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (Get $get): Collection => Type::query()->where('device_type', $get('device_type'))->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Numero de Activo
                Forms\Components\TextInput::make('asset_number')
                    ->translateLabel()
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->maxLength(15),
                // Campo Numero de Serie
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo Condicion
                Forms\Components\Select::make('condition')
                    ->options((['Viejo' => 'Viejo', 'Nuevo' => 'Nuevo']))
                    ->searchable()
                    ->required()
                    ->translateLabel(),
                // Campo Fecha de Ingreso
                Forms\Components\DatePicker::make('entry_date')
                    ->required()
                    ->maxDate(now())
                    ->translateLabel(),
                // Campo Observacion
                Forms\Components\TextInput::make('observation')
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
                Tables\Columns\TextColumn::make('location')
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
                // Columna Programa de Dvr
                Tables\Columns\TextColumn::make('dvr_program')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // Columna Ip
                Tables\Columns\TextColumn::make('ip.ip_number')
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
                    ->onColor('success')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')
                    ->query(fn (Builder $query): Builder => $query->where('device_type', 'camera_dvr')),

                Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => CamerasDVRResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-m-information-circle')
                    ->translateLabel(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCamerasDVRS::route('/'),
            'create' => Pages\CreateCamerasDVR::route('/create'),
            'edit' => Pages\EditCamerasDVR::route('/{record}/edit'),
            'activities' => Pages\ListCamerasDvrActivities::route('/{record}/activities'),
        ];
    }
}
