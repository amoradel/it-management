<?php

namespace App\Filament\Resources\DeviceChangePartnerResource\Pages;

use App\Filament\Resources\DeviceChangePartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListDeviceChangePartners extends ListRecords
{
    protected static string $resource = DeviceChangePartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            ExportAction::make()
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->withFilename('Entregas o Mejoras' . '-' . date('Y-m-d H:i:s'))
                    ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                    ->withColumns([
                        Column::make('description')->heading('Descripción'),
                    ]),
            ]),
        ];
    }
}
