<?php

namespace App\Filament\Resources\POSResource\Pages;

use App\Filament\Resources\POSResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListPOS extends ListRecords
{
    protected static string $resource = POSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename("Pos" . '-' . date('Y-m-d H:i:s'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('condition')->heading('Condición'),
                            Column::make('entry_date')->heading('Fecha de Ingreso'),
                            Column::make('observation')->heading('Observación'),
                        ]),
                ]),
        ];
    }
}
