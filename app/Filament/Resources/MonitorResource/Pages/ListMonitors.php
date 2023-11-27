<?php

namespace App\Filament\Resources\MonitorResource\Pages;

use App\Filament\Resources\MonitorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListMonitors extends ListRecords
{
    protected static string $resource = MonitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make()
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->withFilename("Monitores" . '-' . date('Y-m-d H:i:s'))
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
