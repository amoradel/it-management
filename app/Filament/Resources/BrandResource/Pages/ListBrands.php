<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Imports\BrandsImport;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // ActionGroup::make([
            Actions\Action::make('Import')
                ->requiresConfirmation()
                ->icon('heroicon-o-document-arrow-up')
                ->modalIcon('heroicon-o-document-arrow-up')
                ->modalDescription(__('Do you want to import data from an excel file?'))
                ->translateLabel()
                ->form(
                    [
                        FileUpload::make('excel_file')
                            ->beforeStateDehydrated(null)
                            ->translateLabel()
                            ->required()
                            ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                        Fieldset::make('Match data to column')
                            ->translateLabel()
                            ->columns(1)
                            ->hidden(
                                fn (callable $get) => $get('excel_file') ? false : true
                            )
                            ->schema([
                                Select::make('name')
                                    ->default('name')
                                    ->required()
                                    ->searchable()
                                    ->options(fn (callable $get) => getHeadingRows($get)),

                            ]),
                    ])
                ->action(function (array $data): void {
                    if ($data) {
                        $excel_file = $data['excel_file'];
                        // dd($data['name']);

                        // $filteredData ahora contiene todos los datos excepto 'excel_file'
                        $filteredData = array_filter($data, function ($key) {
                            return $key !== 'excel_file';
                        }, ARRAY_FILTER_USE_KEY);

                        $file = $excel_file->path();
                        Excel::import(import: new BrandsImport($filteredData), filePath: $file);
                    }
                }),
            // ]),
        ];
    }
}
