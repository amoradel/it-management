<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

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
                ]),
        ];
    }
}
