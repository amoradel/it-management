<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ip extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = [];

    // Relaciones uno a uno
    public function device()
    {
        // return $this->belongsTo('App\Models\Device', 'device_id', 'id');
        // return $this->belongsTo('App\Models\Device');
        return $this->hasOne('App\Models\Device');
    }
    // Fin Relaciones uno a uno

    // Función para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'ip_address',
                'device_id',
                'availability',
                'description',
                'ip_type',
                'segment',
                'status',
            ]);
    }
}
