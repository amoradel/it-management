<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\DepartmentResource;
use App\Filament\Resources\PartnerResource;
use App\Models\Partner;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListPartners extends ListRecords
{
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->icon('heroicon-o-document-arrow-up')
                ->modalWidth('md')
                ->uniqueField('name')
                ->fields([
                    ImportField::make('name')
                        ->translateLabel()
                        ->rules('string|max:100')
                        ->required(),
                    ImportField::make('employee_number')
                        ->translateLabel()
                        ->rules('max:20|unique:partners')
                        ->required(),
                    ImportField::make('job_position')
                        ->translateLabel()
                        ->rules('string|max:50')
                        ->required(),
                    ImportField::make('department.name')
                        ->label('Department')
                        ->translateLabel()
                        ->rules('exists:App\Models\Department,name', ['The department name is not registered.'])
                        ->required(),
                    ImportField::make('username_network')
                        ->rules('string|max:15')
                        ->translateLabel(),
                    ImportField::make('username_odoo')
                        ->rules('string|max:15')
                        ->translateLabel(),
                    ImportField::make('username_jde')
                        ->rules('string|max:15')
                        ->translateLabel(),
                    ImportField::make('extension')
                        ->translateLabel()
                        ->rules('max:10')
                        ->required(),
                    ImportField::make('email')
                        ->translateLabel()
                        ->rules('string|max:50')
                        ->required(),

                ])->handleRecordCreation(function (array $data) {
                    if ($department = DepartmentResource::getEloquentQuery()->where('name', $data['department']['name'])->first()) {
                        return Partner::create([
                            'name' => $data['name'],
                            'employee_number' => $data['employee_number'] ?? 'N/D',
                            'job_position' => $data['job_position'] ?? 'N/D',
                            'department_id' => $department->id ?? 'N/D',
                            'username_network' => $data['username_network'] ?? 'N/D',
                            'username_odoo' => $data['username_odoo'] ?? 'N/D',
                            'username_jde' => $data['username_jde'] ?? 'N/D',
                            'extension' => $data['extension'] ?? 'N/D',
                            'email' => $data['email'] ?? 'N/D',
                        ]);
                    }

                    return new Partner();
                }),
        ];
    }
}
