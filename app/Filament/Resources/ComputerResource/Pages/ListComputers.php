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
                    ImportField::make('type.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\Type,name', ['The type name is not registered.'])
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
                    ImportField::make('storage')
                        ->translateLabel()
                        ->rules('max:10')
                        ->required(),
                    ImportField::make('storage_type')
                        ->translateLabel()
                        ->rules('max:20')
                        ->required(),
                    ImportField::make('ram_memory')
                        ->translateLabel()
                        ->rules('max:10')
                        ->required(),
                    ImportField::make('ram_memory_type')
                        ->translateLabel()
                        ->rules('max:20')
                        ->required(),
                    ImportField::make('processor')
                        ->translateLabel()
                        ->rules('max:30')
                        ->required(),
                    ImportField::make('asset_number')
                        ->translateLabel()
                        ->rules('max:20')
                        ->required(),
                    ImportField::make('serial_number')
                        ->translateLabel()
                        ->rules('max:50')
                        ->required(),
                    ImportField::make('anydesk')
                        ->translateLabel()
                        ->rules('max:13')
                        ->required(),
                    ImportField::make('office_version')
                        ->translateLabel()
                        ->rules('in:Office_365,Office_2016,Office_2013,N/D', ['The imported Office version is invalid.'])
                        ->required(),
                    ImportField::make('windows_version')
                        ->translateLabel()
                        ->rules('in:Windows_11,Windows_10,Windows_8,Windows_7,N/D', ['The imported Windows version is invalid.'])
                        ->required(),
                    ImportField::make('condition')
                        ->translateLabel()
                        ->rules('in:used,new', ['The imported condition is invalid.'])
                        ->required(),
                    ImportField::make('description')
                        ->rules('max:150')
                        ->translateLabel()
                        ->required(),
                ])->handleRecordCreation(function (array $data) {
                    $brand = BrandResource::getEloquentQuery()
                        ->where('name', $data['brand']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    $model = DeviceModelResource::getEloquentQuery()
                        ->where('name', $data['model']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    $type = TypeResource::getEloquentQuery()
                        ->where('name', $data['type']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    // dd(isset($brand) && isset($model) && isset($type), isset($brand), isset($model), isset($type));
                    if (isset($brand) && isset($model) && isset($type)) {
                        // dd($data);

                        return Device::create([
                            'name' => trim($data['name']),
                            'location' => trim($data['location']),
                            'brand_id' => $brand->id,
                            'model_id' => $model->id,
                            'type_id' => $type->id,
                            'device_type' => 'computer',
                            'storage' => trim($data['storage']) ?? 'N/D',
                            'storage_type' => trim($data['storage_type']) ?? 'N/D',
                            'ram_memory' => trim($data['ram_memory']) ?? 'N/D',
                            'ram_memory_type' => trim($data['ram_memory_type']) ?? 'N/D',
                            'processor' => trim($data['processor']) ?? 'N/D',
                            'asset_number' => trim($data['asset_number']),
                            'serial_number' => trim($data['serial_number']),
                            'anydesk' => trim($data['anydesk']) ?? 'N/D',
                            'office_version' => trim($data['office_version']),
                            'windows_version' => trim($data['windows_version']),
                            'condition' => trim($data['condition']),
                            'description' => trim($data['description']),
                        ]);
                    }

                    return new Device();
                }),
        ];
    }
}
