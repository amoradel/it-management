<?php

namespace App\Filament\Resources\CamerasDVRResource\Pages;

use App\Filament\Resources\CamerasDVRResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCamerasDVR extends EditRecord
{
    protected static string $resource = CamerasDVRResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
