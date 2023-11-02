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
        // dd($this->data);

        // return new Brand([
        //     'name' => $row[$this->data['name']],
        // ]);

        // return new Brand([
        //     'name' => $row['Name'] ?? $row['name'],
        // ]);
        $brandData = [];

        // Recorrer el array $this->data y construir el array $brandData
        foreach ($this->data as $key => $value) {
            $brandData[$key] = $row[$value] ?? null;
        }

        // Crear un nuevo objeto Brand con los datos construidos
        return new Brand($brandData);

    }
}
