<?php

namespace App\Filament\Resources\CamerasDvrResource\Pages;

use App\Filament\Resources\CamerasDvrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCamerasDvrs extends ListRecords
{
    protected static string $resource = CamerasDvrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
