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
