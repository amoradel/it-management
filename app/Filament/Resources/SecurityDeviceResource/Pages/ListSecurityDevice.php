<?php

namespace App\Filament\Resources\SecurityDeviceResource\Pages;

use App\Enums\DeviceType;
use App\Filament\Resources\BrandResource;
use App\Filament\Resources\DeviceModelResource;
use App\Filament\Resources\SecurityDeviceResource;
use App\Filament\Resources\TypeResource;
use App\Models\Device;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListSecurityDevices extends ListRecords
{
    protected static string $resource = SecurityDeviceResource::class;

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
                    ImportField::make('device_type')
                        ->translateLabel()
                        ->rules('in:camera,dvr,access control,alarm', ['The imported device_type is invalid.'])
                        ->required(),
                    ImportField::make('type.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\Type,name', ['The type name is not registered.'])
                        ->required(),
                    ImportField::make('default_app')
                        ->translateLabel()
                        ->rules('in:IVMS-4200,CMS3.0,VI MonitorPlus')
                        ->required(),
                    ImportField::make('brand.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\Brand,name', ['The brand name is not registered.'])
                        ->required(),
                    ImportField::make('ip.ip_address')
                        ->label('Ip address')
                        ->translateLabel()
                        ->rules('exists:App\Models\Ip,ip_address', ['The ip address is not registered.'])
                        ->required(),
                    ImportField::make('model.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\DeviceModel,name', ['The device model name is not registered.'])
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

                    $model = DeviceModelResource::getEloquentQuery()
                        ->where('name', $data['model']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    $type = TypeResource::getEloquentQuery()
                        ->where('name', $data['type']['name'])
                        ->whereNull('deleted_at')
                        ->first();

                    if (isset($brand) && isset($model) && isset($type)) {
                        return Device::create([
                            'name' => trim($data['name']),
                            'location' => trim($data['location']),
                            'device_type' => trim($data['device_type']) ?? 'N/D',
                            'type_id' => $type->id,
                            'default_app' => trim($data['default_app']),
                            'brand_id' => $brand->id,
                            'model_id' => $model->id,
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

    public function getTabs(): array
    {
        $count_all = $this->getModel()::
            where('device_type', DeviceType::Camera->value)
            ->orWhere('device_type', DeviceType::Dvr->value)
            ->orWhere('device_type', DeviceType::AccessControl->value)
            ->orWhere('device_type', DeviceType::Alarm->value)
            ->count();

        $tabs = ['all' => Tab::make(__('All'))->badge($count_all)];

        $segments = array_merge(
            DeviceType::Camera->getOption(),
            DeviceType::Dvr->getOption(),
            DeviceType::AccessControl->getOption(),
            DeviceType::Alarm->getOption()
        );

        foreach ($segments as $key => $value) {
            $slug = str($key)->slug()->toString();
            $tabs[$slug] = Tab::make($value)
                ->badge(Device::where('device_type', $key)->count())
                ->modifyQueryUsing(function ($query) use ($key) {
                    return $query->where('device_type', $key);
                });
        }

        return $tabs;

        // $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];

        // $segments = getGroupedColumnValues(table: 'ips', column: 'segment');

        // foreach ($segments as $segment) {
        //     $slug = str($segment)->slug()->toString();

        //     $tabs[$slug] = Tab::make($segment)
        //         ->badge(Ip::where('segment', $segment)->count())
        //         ->modifyQueryUsing(function ($query) use ($segment) {
        //             return $query->where('segment', $segment);
        //         });
        // }

        // return $tabs;
    }
}
