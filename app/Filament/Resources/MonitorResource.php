<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitorResource\Pages;
use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class MonitorResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Monitor';

    protected static ?string $pluralModelLabel = 'Monitores';

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    protected static ?int $navigationSort = 2;

    private const DEVICE_TYPE = 'monitor';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignorable: fn ($record) => $record)
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Ubicación
                Forms\Components\TextInput::make('location')
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'location'))
                    ->required()
                    ->maxLength(50)
                    ->prefixIcon('heroicon-m-map-pin')
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (): Collection => Type::query()->where('device_type', self::DEVICE_TYPE)->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->prefixIcon('heroicon-m-rectangle-stack')
                    ->translateLabel(),
                // Campo Marca
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->prefixIcon('heroicon-m-tag')
                    ->translateLabel(),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->label('Model')
                    ->options(fn (Get $get): Collection => DeviceModel::query()->where('brand_id', $get('brand_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->prefixIcon('heroicon-m-swatch')
                    ->required()
                    ->translateLabel(),
                // Campo Numero de Activo
                Forms\Components\TextInput::make('asset_number')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignorable: fn ($record) => $record)
                    ->prefixIcon('heroicon-m-hashtag')
                    ->translateLabel(),
                // Campo Numero de Serie
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignorable: fn ($record) => $record)
                    ->prefixIcon('heroicon-m-hashtag')
                    ->translateLabel(),
                // Campo Condición
                Forms\Components\Select::make('condition')
                    ->options((['used' => 'En uso', 'new' => 'Nuevo']))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->translateLabel(),
                // Campo Fecha de Ingreso
                Forms\Components\DatePicker::make('entry_date')
                    ->required(fn ($get) => $get('condition') == 'new' ? true : false)
                    ->maxDate(now())
                    ->translateLabel(),
                // Campo Descripción
                Forms\Components\Textarea::make('description')
                    ->maxLength(150)
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Columna que envía el tipo de equipo
                Forms\Components\Hidden::make('device_type')
                    ->default(self::DEVICE_TYPE),
            ])->columns(['sm' => 2, 'xl' => 4]);
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
                // Columna Ubicación
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
                // Columna Condición
                Tables\Columns\TextColumn::make('condition')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Fecha de entrada
                Tables\Columns\TextColumn::make('entry_date')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Observación
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Estado
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->onColor('success'),
            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')
                    ->query(fn (Builder $query): Builder => $query->where('device_type', self::DEVICE_TYPE)),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => MonitorResource::getUrl('activities', ['record' => $record]))
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
            'index' => Pages\ListMonitors::route('/'),
            'create' => Pages\CreateMonitor::route('/create'),
            'edit' => Pages\EditMonitor::route('/{record}/edit'),
            'activities' => Pages\ListMonitorActivities::route('/{record}/activities'),
        ];
    }
}
