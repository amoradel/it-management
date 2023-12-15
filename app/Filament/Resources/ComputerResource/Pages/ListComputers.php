<?php

namespace App\Filament\Resources\ComputerResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\ComputerResource;
use App\Filament\Resources\DeviceModelResource;
use App\Filament\Resources\TypeResource;
use App\Models\Device;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListComputers extends ListRecords
{
    protected static string $resource = ComputerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->icon('heroicon-o-document-arrow-up')
                ->modalWidth('md')
                ->uniqueField('name')
                ->fields([
                    ImportField::make('name')
                        ->translateLabel()
                        ->rules('required|max:15')
                        ->required(),
                    ImportField::make('location')
                        ->translateLabel()
                        ->rules('required|max:50')
                        ->required(),
                    ImportField::make('brand.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\Brand,name', ['The brand name is not registered.'])
                        ->required(),
                    ImportField::make('model.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\DeviceModel,name', ['The device model name is not registered.'])
                        ->required(),
                    ImportField::make('type.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\Type,name', ['The type name is not registered.'])
                        ->required(),
                    ImportField::make('storage')
                        ->translateLabel()
                        ->rules('required|max:30')
                        ->required(),
                    ImportField::make('ram_memory')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('processor')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('serial_number')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('anydesk')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('office_version')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('windows_version')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('condition')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('entry_date')
                        ->translateLabel()
                        ->required(),
                    ImportField::make('description')
                        ->translateLabel()
                        ->required(),
                ])->handleRecordCreation(function (array $data) {
                    $brand = BrandResource::getEloquentQuery()->where('name', $data['brand']['name'])->first();

                    $model = DeviceModelResource::getEloquentQuery()->where('name', $data['model']['name'])->first();

                    $type = TypeResource::getEloquentQuery()->where('name', $data['brand']['name'])->first();

                    if ($brand && $model && $type) {
                        return Device::create([
                            'name' => $data['name'],
                            'location' => $data['location'],
                            'brand_id' => $brand->id,
                            'model_id' => $model->id,
                            'type_id' => $type->id,
                            'device_type' => 'computer',
                            'description' => $data['description'],
                            'storage' => $data['storage'],
                            'ram_memory' => $data['ram_memory'],
                            'processor' => $data['processor'],
                            'asset_number' => $data['asset_number'],
                            'serial_number' => $data['serial_number'],
                            'anydesk' => $data['anydesk'],
                            'office_version' => $data['office_version'],
                            'windows_version' => $data['windows_version'],
                            'dvr_program' => $data['dvr_program'],
                            'observation' => $data['observation'],
                            'condition' => $data['condition'],
                            'entry_date' => $data['entry_date'],
                        ]);
                    }

                    return new Device();
                }),
        ];
    }
}
