<?php

namespace App\Filament\Resources\CamerasDvrResource\Pages;

use App\Filament\Resources\CamerasDvrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListCamerasDvrs extends ListRecords
{
    protected static string $resource = CamerasDvrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            ExportAction::make()
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->withFilename("Camaras-Dvr's" . '-' . date('Y-m-d'))
                    ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                    ->withColumns([
                        Column::make('dvr_program')->heading('Programa de Dvr'),
                        Column::make('condition')->heading('Condición'),
                        Column::make('enrty_date')->heading('Fecha de Ingreso'),
                        Column::make('observation')->heading('Observación'),
                        Column::make('state')->heading('Estado'),
                    ]),
            ]),
        ];
    }
}
