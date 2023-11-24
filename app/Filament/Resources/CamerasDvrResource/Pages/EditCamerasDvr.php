<?php

namespace App\Filament\Resources\CamerasDvrResource\Pages;

use App\Filament\Resources\CamerasDvrResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCamerasDvr extends EditRecord
{
    protected static string $resource = CamerasDvrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
