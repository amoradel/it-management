<?php

namespace App\Imports;

use App\Models\DeviceModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeviceModelsImport implements ToModel, WithHeadingRow
{
    private $data = [];

    public function __construct(array $data = null)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $modelData = [];

        // Recorrer el array $this->data y construir el array $brandData
        foreach ($this->data as $key => $value) {
            $modelData[$key] = $row[$value] ?? null;
        }

        return new DeviceModel($modelData);
    }
}
