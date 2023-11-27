<?php

namespace App\Filament\Resources\DeviceChangeResource\Pages;

use App\Filament\Resources\DeviceChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListDeviceChanges extends ListRecords
{
    protected static string $resource = DeviceChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename('Equipos o Piezas' . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),
                ]),
        ];
    }
}
