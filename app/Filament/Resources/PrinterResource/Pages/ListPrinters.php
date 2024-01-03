<?php

namespace App\Filament\Resources\PrinterResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\DeviceModelResource;
use App\Filament\Resources\IpResource;
use App\Filament\Resources\PrinterResource;
use App\Filament\Resources\TypeResource;
use App\Models\Device;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListPrinters extends ListRecords
{
    protected static string $resource = PrinterResource::class;

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
                        ->rules('required')
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
                    ImportField::make('ip.ip_address')
                        ->label('Ip address')
                        ->translateLabel()
                        ->rules('exists:App\Models\Ip,ip_address', ['The ip address is not registered.'])
                        ->required(),
                    ImportField::make('asset_number')
                        ->translateLabel()
                        ->rules('max:20')
                        ->required(),
                    ImportField::make('serial_number')
                        ->translateLabel()
                        ->rules('max:50')
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

                    $device_model = DeviceModelResource::getEloquentQuery()
                        ->where('name', $data['model']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    $type = TypeResource::getEloquentQuery()
                        ->where('name', $data['type']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    $ip = IpResource::getEloquentQuery()
                        ->where('ip_address', $data['ip']['ip_address'])
                        ->whereNull('deleted_at')
                        ->first();

                    // dd(isset($brand) && isset($model) && isset($type), isset($brand), isset($model), isset($type));
                    if (isset($brand) && isset($device_model) && isset($type) && isset($ip)) {
                        // dd($data);
                        return Device::create([
                            'name' => trim($data['name']),
                            'location' => trim($data['location']),
                            'brand_id' => $brand->id,
                            'model_id' => $device_model->id,
                            'type_id' => $type->id,
                            'ip_id' => $ip->id,
                            'device_type' => 'printer',
                            'asset_number' => trim($data['asset_number']),
                            'serial_number' => trim($data['serial_number']),
                            'condition' => trim($data['condition']),
                            'description' => trim($data['description']),
                        ]);
                    }

                    return new Device();
                }),

        ];
    }
}
