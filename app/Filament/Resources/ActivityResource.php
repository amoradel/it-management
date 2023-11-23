<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationGroup = 'Procesos';

    protected static ?string $modelLabel = 'Actividad';

    protected static ?string $pluralModelLabel = 'Actividades';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(60)
                    ->translateLabel(),
                // Campo Descripcion
                Forms\Components\Textarea::make('description')
                    ->maxLength(150)
                    ->translateLabel(),
                // Campo Seleccion Usuarios
                Forms\Components\Select::make('partner_id')
                    ->relationship('partner', 'name')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Seleccion Dispositivos
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
                // Campo Estado
                Forms\Components\Select::make('state')
                    ->options(['approved' => 'Aprobado', 'not approved' => 'No Aprobado', 'waiting' => 'En Espera', 'in progress' => 'En Proceso', 'done' => 'Finalizado'])
                    ->searchable()
                    ->required()
                    ->translateLabel(),
                // Campo Para Subir Reportes(PDF) Firmados
                FileUpload::make('attached_img')
                    ->translateLabel()
                    ->columnSpan(2)
                    ->AcceptedFileTypes(['image/jpeg', 'image/png'])
                    ->downloadable()
                    ->preserveFilenames()
                    ->maxFiles(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('name')
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
                // Columna Roles
                Tables\Columns\TextColumn::make('state')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'info',
                        'not approved' => 'danger',
                        'waiting' => 'waiting',
                        'in progress' => 'gray',
                        'done' => 'success',
                    })
                    ->wrap()
                    ->translateLabel(),
                // Columna Usuario
                Tables\Columns\TextColumn::make('partner.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Dispositivo
                Tables\Columns\TextColumn::make('device.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('state')
                ->options([
                    'new' => 'New',
                    'waiting' => 'Waiting',
                    'in progress' => 'In Progress',
                    'close' => 'Close',
                    'abort' => 'Abort',
                ])->multiple()
                ->translateLabel(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => ActivityResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-m-information-circle')
                    ->translateLabel(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
            'activities' => Pages\ListActivityActivities::route('/{record}/activities'),
        ];
    }
}
