<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComputerResource\Pages;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class ComputerResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Computadora';

    protected static ?string $pluralModelLabel = 'Computadoras';

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(15)
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
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (): Collection => Type::query()->where('device_type', 'computer')->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->prefixIcon('heroicon-m-rectangle-stack')
                    ->columnSpan([
                        'xl' => '2',
                    ])
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
                // Campo Almacenamiento
                Forms\Components\TextInput::make('storage')
                    ->required()
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'storage'))
                    ->maxLength(10)
                    ->prefixIcon('heroicon-m-circle-stack')
                    // ->suffix('GB')
                    ->translateLabel(),
                // Campo Tipo de Almacenamiento
                Forms\Components\TextInput::make('storage_type')
                    ->required()
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'storage_type'))
                    ->maxLength(20)
                    ->translateLabel(),
                // Campo RAM
                Forms\Components\TextInput::make('ram_memory')
                    ->required()
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'ram_memory'))
                    ->maxLength(10)
                    ->prefixIcon('heroicon-m-queue-list')
                    // ->suffix('GB')
                    ->translateLabel(),
                // Campo Tipo de RAM
                Forms\Components\TextInput::make('ram_memory_type')
                    ->required()
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'ram_memory_type'))
                    ->maxLength(20)
                    ->translateLabel(),
                // Campo Procesador
                Forms\Components\TextInput::make('processor')
                    ->maxLength(30)
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'processor'))
                    ->prefixIcon('heroicon-m-cpu-chip')
                    ->required()
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Dirección IP
                Forms\Components\Select::make('ip_id')
                    ->relationship('ip', 'ip_address')
                    ->unique(ignorable: fn ($record) => $record)
                    ->searchable()
                    ->preload()
                    ->prefixIcon('heroicon-m-wifi')
                    ->translateLabel(),
                // Campo Any Desk
                Forms\Components\TextInput::make('anydesk')
                    ->required()
                    ->maxLength(13)
                    ->unique(ignorable: fn ($record) => $record)
                    ->prefix('')
                    ->suffixAction(
                        Forms\Components\Actions\Action::make('Open Anydesk')
                            ->icon('si-anydesk')
                            ->color('danger')
                            ->translateLabel()
                            ->url(fn ($state) => 'anydesk:' . str_replace(' ', '', $state))
                    )
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
                // Campo Selección Usuarios
                Forms\Components\Select::make('partner_id')
                    ->relationship('partners', 'name')
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->prefixIcon('heroicon-m-user')
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Version Office
                Forms\Components\Select::make('office_version')
                    ->options(['Office_365' => 'Office 365', 'Office_2016' => 'Office 2016', 'Office_2013' => 'Office 2013'])
                    ->searchable()
                    ->required()
                    ->translateLabel(),
                // Campo Version Windows
                Forms\Components\Select::make('windows_version')
                    ->options(['Windows_11' => 'Windows 11', 'Windows_10' => 'Windows 10', 'Windows_8' => 'Windows 8', 'Windows_7' => 'Windows 7'])
                    ->searchable()
                    ->required()
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
                        'sm' => 2, 'xl' => 4,
                    ])
                    ->translateLabel(),
                // Campo que envía el tipo de equipo igual a computer
                Forms\Components\Hidden::make('device_type')
                    ->default('computer'),

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
                // Columna Ubicación
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->translateLabel(),
                // Columna Usuarios
                Tables\Columns\TextColumn::make('partners.name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->toggleable()
                    ->translateLabel(),
                // Columna Any Desk
                Tables\Columns\TextColumn::make('anydesk')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($state) => 'anydesk:' . str_replace(' ', '', $state))
                    ->translateLabel(),
                // Columna Ip
                Tables\Columns\TextColumn::make('ip.ip_address')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Numero de activo
                Tables\Columns\TextColumn::make('asset_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Tipo
                Tables\Columns\TextColumn::make('type.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Descripción
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Almacenamiento
                Tables\Columns\TextColumn::make('storage')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Memoria RAM
                Tables\Columns\TextColumn::make('ram_memory')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Procesador
                Tables\Columns\TextColumn::make('processor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Version de Office
                Tables\Columns\TextColumn::make('office_version')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Version de Windows
                Tables\Columns\TextColumn::make('windows_version')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Condición
                Tables\Columns\TextColumn::make('condition')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                // Columna Fecha de Entrada
                Tables\Columns\TextColumn::make('entry_date')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('device_type', 'computer')),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => ComputerResource::getUrl('activities', ['record' => $record]))
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
            'index' => Pages\ListComputers::route('/'),
            'create' => Pages\CreateComputer::route('/create'),
            'edit' => Pages\EditComputer::route('/{record}/edit'),
            'activities' => Pages\ListComputerActivities::route('/{record}/activities'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
