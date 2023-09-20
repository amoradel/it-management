<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComputerResource\Pages;
use App\Filament\Resources\ComputerResource\RelationManagers;
use App\Filament\Resources\ComputerResource\RelationManagers\PartnersRelationManager;
use App\Models\Device;
use App\Models\Device_model;
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

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

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
                    ->maxLength(15)
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
                // Columna que envia el tipo de equipo igual a computer
                Forms\Components\Hidden::make('device_type')
                    ->default('computer'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('ubication')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('any_desk')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('asset_number')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('model.name')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type.name')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('historic')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('storage')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ram_memory')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('processor')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('office_version')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('windows_version')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('condition')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('entry_date')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->onColor('success'),
            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')->query(fn (Builder $query): Builder => $query->where('device_type', 'computer'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListComputers::route('/'),
            'create' => Pages\CreateComputer::route('/create'),
            'edit' => Pages\EditComputer::route('/{record}/edit'),
        ];
    }
}
