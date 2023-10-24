<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Imports\BrandsImport;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ActionGroup::make([
                Actions\Action::make('Import')
                    ->requiresConfirmation()
                    ->translateLabel()

                    ->form([
                        FileUpload::make('excel-file')
                            ->beforeStateDehydrated(null)
                            ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                    ])
                    ->action(function (array $data): void {
                        if ($data) {
                            $excel_file = $data['excel-file'];
                            // dd($data, $excel_file->path());
                            // dd(storage_path($data['excel-file']));
                            // $file = storage_path('app/public/' . $data['excel-file']);
                            $file = $excel_file->path();
                            // $file = $data['excel-file'];
                            // dd($file);
                            Excel::import(import: new BrandsImport, filePath: $file);

                        }
                    }),
            ]),
        ];
    }
}
