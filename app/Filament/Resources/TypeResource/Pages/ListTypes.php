<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Filament\Resources\TypeResource;
use App\Models\Type;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListTypes extends ListRecords
{
    protected static string $resource = TypeResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->icon('heroicon-o-document-arrow-up')
                ->modalWidth('md')
                ->uniqueField('name')
                ->fields([
                    ImportField::make('device_type')
                        ->label('Device name')
                        ->required(),
                    ImportField::make('name')
                        ->required(),
                    ImportField::make('description'),
                ])->handleRecordCreation(function (array $data) {
                    $options = [
                        'computer',
                        'printer',
                        'camera',
                        'monitor',
                        'pos',
                        'dvr',
                        'others',
                        'Computadora',
                        'Impresora',
                        'Camara',
                        'Monitor',
                        'Pos',
                        'Dvr',
                        'Accesorios y Otros',
                    ];

                    if (in_array($data['device_type'], $options)) {
                        $documentData = [
                            'device_type' => $data['device_type'],
                            'name' => $data['name'],
                        ];
    
                        if (isset($data['description'])) {
                            $documentData['description'] = $data['description'];
                        }
    
                        return Type::create($documentData);
                    }


                    return new Type();
                }),
        ];
    }
}
