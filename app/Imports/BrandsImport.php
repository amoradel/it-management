<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandsImport implements ToModel, WithHeadingRow
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

        // Crear un nuevo objeto Brand con los datos construidos
        return new Brand($modelData);
    }
}
