<?php

namespace App\Filament\Resources\PrinterResource\Pages;

use App\Filament\Resources\PrinterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListPrinters extends ListRecords
{
    protected static string $resource = PrinterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename("Impresoras" . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('brand.name')->heading('Marca'),
                            Column::make('model.name')->heading('Modelo'),
                            Column::make('type.name')->heading('Tipo'),
                            Column::make('description')->heading('Descripción'),
                            Column::make('condition')->heading('Condición'),
                            Column::make('entry_date')->heading('Fecha de Ingreso'),
                        ]),
                ]),
        ];
    }
}
