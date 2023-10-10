<?php

namespace App\Filament\Resources\CamerasDVRResource\Pages;

use App\Filament\Resources\CamerasDVRResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCamerasDVRS extends ListRecords
{
    protected static string $resource = CamerasDVRResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
