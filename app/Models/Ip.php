<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ip extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = [];

    // Relaciones uno a uno
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }
    // Fin Relaciones uno a uno

    // Funcion para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'ip_number',
                'device_id',
                'availability',
                'description',
                'ip_type',
                'segment',
                'status',
            ]);
    }
}
