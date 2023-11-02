<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Imports\BrandsImport;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // ActionGroup::make([
            Actions\Action::make('Import')
                ->icon('heroicon-o-document-arrow-up')
                ->requiresConfirmation()
                ->translateLabel()
                ->form([
                    FileUpload::make('excel_file')
                        ->beforeStateDehydrated(null)
                        ->translateLabel()
                        ->required()
                        ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                    Select::make('name')
                        ->default('name')
                        ->required()
                        ->searchable()
                        ->options(function (callable $get): array {
                            if ($get('excel_file')) {
                                $file = $get('excel_file');
                                // dd($file);
                                $uploadedFile = reset($file); // Obtener el primer elemento del array
                                $file_path = $uploadedFile->path();
                                $headings = (new HeadingRowImport)->toArray($file_path);
                                $headings = reset($headings);
                                $headings = reset($headings);

                                $headings = array_combine($headings, $headings);
                                // dd($headings);

                                return $headings;
                            } else {
                                return [];
                            }
                        })
                        ->hidden(
                            fn (callable $get) => $get('excel_file') ? false : true
                        ),
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
