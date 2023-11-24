<?php

namespace App\Filament\Resources\PrinterResource\Pages;

use App\Filament\Resources\PrinterResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListPrinterActivities extends ListActivities
{
    protected static string $resource = PrinterResource::class;
}
