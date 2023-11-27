<?php

namespace App\Filament\Resources\CamerasDvrResource\Pages;

use App\Filament\Resources\CamerasDvrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
                    ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),
            ]),
        ];
    }
}
