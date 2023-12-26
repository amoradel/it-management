<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IpResource\Pages;
use App\Models\Device;
use App\Models\Ip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IpResource extends Resource
{
    protected static ?string $model = Ip::class;

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Ip';

    protected static ?string $pluralModelLabel = "Ip's";

    protected static ?string $navigationIcon = 'heroicon-o-wifi';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Ip Number
                Forms\Components\TextInput::make('ip_address')
                    ->required()
                    ->maxLength(15)
                    ->placeholder('127.0.0.1')
                    ->ipv4()
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo Equipo
                Forms\Components\Select::make('device_id')
                    ->relationship('device', 'name')
                    ->searchable()
                    ->preload()
                    ->translateLabel()
                    ->reactive()
                    ->options(function (Device $device) {
                        return $device->whereDoesntHave('ip')->pluck('name', 'id');
                    })
                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                        $set('availability', getAvailability($state, $get('description')));
                    }),
                // Campo Descripción
                Forms\Components\Textarea::make('description')
                    ->translateLabel()
                    ->reactive()
                    ->maxLength(150)
                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                        $set('availability', getAvailability($state, $get('device_id')));
                    }),
                // Campo Tipo de Ip
                Forms\Components\Select::make('ip_type')
                    ->options(['static' => 'Estática', 'dynamic' => 'Dinámica'])
                    ->searchable()
                    ->required()
                    ->translateLabel(),
                // Campo Tipo de Ip
                Forms\Components\TextInput::make('assignment_type')
                    ->datalist(fn () => getGroupedColumnValues(table: 'ips', column: 'assignment_type'))
                    ->maxLength(30)
                    ->required()
                    ->translateLabel(),
                // Campo Segmento
                Forms\Components\TextInput::make('segment')
                    ->placeholder('127.0.0.1 - 127.0.0.255')
                    ->maxLength(40)
                    ->required()
                    ->translateLabel(),
                Forms\Components\Select::make('status')
                    ->options(['configured' => 'Configurado', 'not configured' => 'No Configurado', 'pending' => 'Pendiente'])
                    ->searchable()
                    ->translateLabel(),
                Forms\Components\TextInput::make('availability')
                    ->readOnly(),
                // Campo Estado
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Nombre
                Tables\Columns\TextColumn::make('device.name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->translateLabel(),
                // Columna Tipo de Ip
                Tables\Columns\TextColumn::make('ip_type')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Descripción
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Disponibilidad
                Tables\Columns\TextColumn::make('availability')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Segmento
                Tables\Columns\TextColumn::make('segment')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Estado
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->onColor('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('availability')
                    ->options([
                        'Ocupado' => 'Ocupado',
                        'Disponible' => 'Disponible',
                    ])
                    ->translateLabel(),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => IpResource::getUrl('activities', ['record' => $record]))
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
            'index' => Pages\ListIps::route('/'),
            'create' => Pages\CreateIp::route('/create'),
            'edit' => Pages\EditIp::route('/{record}/edit'),
            'activities' => Pages\ListIpsActivities::route('/{record}/activities'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
