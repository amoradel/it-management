<?php

function setAvailability($value, $value2)
{
    if (trim($value) == '' and trim($value2) == '') {
        return 'Disponible';
    } else {
        return 'Ocupado';
    }
}

function getTimeStamp(): string
{
    // Obtener la fecha y hora actuales con milisegundos
    $microtime = microtime(true);
    $micro = sprintf('%06d', ($microtime - floor($microtime)) * 1000000);
    $datetime = new DateTime(date('Y-m-d H:i:s.' . $micro, $microtime));

    // Devolver la fecha y hora actuales con milisegundos
    return (string) $datetime->format('Y-m-d H:i:s.u');
}

function getHeadingRows(callable $get): array
{
    if ($get('excel_file')) {
        $file = $get('excel_file');
        // dd($file);
        $uploadedFile = reset($file); // Obtener el primer elemento del array
        $file_path = $uploadedFile->path();
        $headings = (new \Maatwebsite\Excel\HeadingRowImport)->toArray($file_path);
        $headings = reset($headings);
        $headings = reset($headings);

        $headings = array_combine($headings, $headings);
        // dd($headings);

        return $headings;
    } else {
        return [];
    }
}

function getGroupedColumnValues(string $table, string $column): array
{
    $data = DB::table($table)
        ->select(DB::raw($column . ' as data'))
        ->groupBy(DB::raw($column))
        ->pluck('data');

    $data = $data->flip()->combine($data)->toArray();
    $data = array_combine($data, $data);

    return $data;
}
