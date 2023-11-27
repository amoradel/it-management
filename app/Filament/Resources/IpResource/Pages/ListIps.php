<?php

namespace App\Filament\Resources\IpResource\Pages;

use App\Filament\Resources\IpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListIps extends ListRecords
{
    protected static string $resource = IpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename("Ip's" . '-' . date('Y-m-d H:i:s'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('ip_type')->heading('Tipo de Ip'),
                            Column::make('status')->heading('Estado'),
                        ]),
                ]),
        ];
    }
}
