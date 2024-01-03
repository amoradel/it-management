<?php

namespace App\Filament\Resources\CamerasDvrResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\CamerasDvrResource;
use App\Filament\Resources\DeviceModelResource;
use App\Filament\Resources\TypeResource;
use App\Models\Device;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListCamerasDvrs extends ListRecords
{
    protected static string $resource = CamerasDvrResource::class;

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
                        ->required(),
                    ImportField::make('location')
                        ->required(),
                    ImportField::make('brand.name')
                        ->label('Brand name')
                        ->required(),
                    ImportField::make('model.name')
                        ->label('Model name')
                        ->required(),
                    ImportField::make('type.name')
                        ->label('Type name')
                        ->required(),
                    ImportField::make('device_type')
                        ->required(),
                    ImportField::make('asset_number')
                        ->required(),
                    ImportField::make('serial_number')
                        ->required(),
                    ImportField::make('condition')
                        ->required(),
                    ImportField::make('entry_date')
                        ->required(),
                    ImportField::make('status')
                        ->required(),
                ])->handleRecordCreation(function (array $data) {
                    $options = [
                        'camera',
                        'dvr',
                        'IVMS-4200',
                        'CMS3.0',
                        'VI MonitorPlus',
                        'Viejo',
                        'Nuevo',
                    ];

                    $brand = BrandResource::getEloquentQuery()->where('name', $data['brand']['name'])->first();
                    $model = DeviceModelResource::getEloquentQuery()->where('name', $data['model']['name'])->first();
                    $type = TypeResource::getEloquentQuery()->where('name', $data['type']['name'])->first();

                    if ($brand && $model && $type) {
                        $documentData = [
                            'name' => $data['name'],
                            'brand_id' => $brand->id,
                            'model_id' => $model->id,
                            'type_id' => $type->id,
                            'device_type' => $data['device_type'],
                            'condition' => $data['condition'],
                            'location' => $data['location'],
                            'asset_number' => $data['asset_number'],
                            'serial_number' => $data['serial_number'],
                            'entry_date' => Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($data['entry_date'] - 2),
                            // 'status' => $data['status'],
                        ];

                        if (isset($data['dvr_program'])) {
                            $documentData['dvr_program'] = $data['dvr_program'];
                        }

                        return Device::create($documentData);
                    }

                    // AUN NO FUNCIONA LA VALIDACION DE DATOS
                    return new Device();
                }),
        ];
    }
}
