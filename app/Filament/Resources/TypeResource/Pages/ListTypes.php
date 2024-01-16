<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Enums\DeviceType;
use App\Filament\Resources\TypeResource;
use App\Models\Type;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListTypes extends ListRecords
{
    protected static string $resource = TypeResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->icon('heroicon-o-document-arrow-up')
                ->modalWidth('md')
                ->uniqueField('name')
                ->fields([
                    ImportField::make('device_type')
                        ->label('Device type')
                        ->translateLabel()
                        ->rules('in:' . DeviceType::getAllOnString(), ['The imported device type is invalid.'])
                        ->required(),
                    ImportField::make('name')
                        ->translateLabel()
                        ->helperText(__('Type name'))
                        ->required(),
                    ImportField::make('description')
                        ->translateLabel(),
                ])->handleRecordCreation(function (array $data) {
                    return Type::create([
                        'device_type' => $data['device_type'],
                        'name' => $data['name'],
                        'description' => isset($data['description']) ? $data['description'] : '',
                    ]);
                }),
        ];
    }
}
