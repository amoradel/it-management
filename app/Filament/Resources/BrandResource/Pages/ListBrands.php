<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Imports\BrandImporter;
use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(BrandImporter::class),
        ];
    }
}
