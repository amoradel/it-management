<?php

namespace App\Filament\Resources\ModelResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\ModelResource;
use App\Models\DeviceModel;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListModels extends ListRecords
{
    protected static string $resource = ModelResource::class;

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
                    ImportField::make('brand.name')
                        ->label('Brand name')
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
