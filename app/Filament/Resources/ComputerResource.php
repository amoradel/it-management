<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComputerResource\Pages;
use App\Filament\Resources\ComputerResource\RelationManagers;
use App\Filament\Resources\ComputerResource\RelationManagers\PartnersRelationManager;
use App\Models\Device;
use App\Models\Device_model;
use App\Models\Ip;
use App\Models\Type;
use Doctrine\DBAL\Schema\Schema;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use Filament\Forms\Get;
use Illuminate\Support\Collection;

class ComputerResource extends Resource
{
    protected static ?string $model = Device::class;
    protected static ?string $navigationGroup = 'Dispositivos';
    protected static ?string $modelLabel = 'Computadora';
    protected static ?string $pluralModelLabel = 'Computadoras';
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

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
                    ->translateLabel()
                    ->afterStateUpdated(function (callable $set) {
                        $set('model_id', null);
                        $set('type_id', null);
                    }),
                // Campo Ubicacion
                Forms\Components\TextInput::make('ubication')
                    ->required()
                    ->maxLength(50)
                    ->translateLabel(),
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
                // Campo Descripcion
                Forms\Components\Textarea::make('description')
                    ->maxLength(300)
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (Get $get): Collection => Type::query()->where('model_id', $get('model_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Historico
                Forms\Components\TextInput::make('historic')
                    ->maxLength(150)
                    ->translateLabel(),
                // Campo Almacenamiento
                Forms\Components\TextInput::make('storage')
                    ->required()
                    ->maxLength(10)
                    ->translateLabel(),
                // Campo RAM
                Forms\Components\TextInput::make('ram_memory')
                    ->required()
                    ->maxLength(10)
                    ->translateLabel(),
                // Campo Procesador
                Forms\Components\TextInput::make('processor')
                    ->maxLength(20)
                    ->required()
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
                // Campo Any Desk
                Forms\Components\TextInput::make('any_desk')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo Version Office
                Forms\Components\Select::make('office_version')
                    ->options(['2013' => '2013', '2016' => '2016', '2019' => '2019'])
                    ->required()
                    ->translateLabel(),
                // Campo Version Windows
                Forms\Components\Select::make('windows_version')
                    ->options(['Windows 10' => 'Windows 10', 'Windows 11' => 'Windows 11'])
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
                // Campo Seleccion Usuarios
                Forms\Components\Select::make('partner_id')
                    ->relationship('partners', 'name')
                    ->preload()
                    ->multiple()
                    ->translateLabel(),
                // Campo Estado
                Forms\Components\Toggle::make('status')
                    ->onColor('success')
                    ->default('true')
                    ->translateLabel(),
                // Campo que envia el tipo de equipo igual a computer
                Forms\Components\Hidden::make('device_type')
                    ->default('computer'),
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
                // Columna Ubicacion
                Tables\Columns\TextColumn::make('ubication')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Usuarios
                Tables\Columns\TextColumn::make('partners.name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Any Desk
                Tables\Columns\TextColumn::make('any_desk')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de activo
                Tables\Columns\TextColumn::make('asset_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ip
                Tables\Columns\TextColumn::make('ip.ip_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Tipo
                Tables\Columns\TextColumn::make('type.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Descripcion
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Historico
                Tables\Columns\TextColumn::make('historic')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Almacenamiento
                Tables\Columns\TextColumn::make('storage')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Memoria RAM
                Tables\Columns\TextColumn::make('ram_memory')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Procesador
                Tables\Columns\TextColumn::make('processor')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Version de Office
                Tables\Columns\TextColumn::make('office_version')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Version de Windows
                Tables\Columns\TextColumn::make('windows_version')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Condicion
                Tables\Columns\TextColumn::make('condition')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Fecha de Entrada
                Tables\Columns\TextColumn::make('entry_date')
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
                    ->query(fn (Builder $query): Builder => $query
                        ->where('device_type', 'computer')),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
        ];
    }
}
