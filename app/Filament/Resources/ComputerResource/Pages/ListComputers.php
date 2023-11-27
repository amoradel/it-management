<?php

namespace App\Filament\Resources\ComputerResource\Pages;

use App\Filament\Resources\ComputerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListComputers extends ListRecords
{
    protected static string $resource = ComputerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            
            ExportAction::make()
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->withFilename("Computadoras" . '-' . date('Y-m-d'))
                    ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                    ->withColumns([
                        Column::make('brand.name')->heading('Marca'),
                        Column::make('model.name')->heading('Modelo'),
                        Column::make('type.name')->heading('Tipo'),
                        Column::make('description')->heading('Descripción'),
                        Column::make('storage')->heading('Almacenamiento'),
                        Column::make('ram_memory')->heading('Memoria Ram'),
                        Column::make('processor')->heading('Procesador'),
                        Column::make('office_version')->heading('Versión de Office'),
                        Column::make('windows-version')->heading('Versión de Windows'),
                        Column::make('condition')->heading('Condición'),
                        Column::make('entry_date')->heading('Fecha de Ingreso'),
                        Column::make('state')->heading('Estado'),
                    ]),
            ]),
        ];
    }
}
