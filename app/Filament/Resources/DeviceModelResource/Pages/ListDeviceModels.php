<?php

namespace App\Filament\Resources\DeviceModelResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\DeviceModelResource;
use App\Models\DeviceModel;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListDeviceModels extends ListRecords
{
    protected static string $resource = DeviceModelResource::class;

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
                        ->required(),
                    ImportField::make('brand.name')
                        ->label('Brand name')
                        ->translateLabel()
                        ->rules('exists:App\Models\Brand,name', ['The brand name is not registered.'])
                        ->required(),
                ])->handleRecordCreation(function (array $data) {
                    if ($brand = BrandResource::getEloquentQuery()->where('name', $data['brand']['name'])->first()) {
                        return DeviceModel::create([
                            'name' => $data['name'],
                            'brand_id' => $brand->id,
                        ]);
                    }

                    return new DeviceModel();
                }),
        ];
    }
}
