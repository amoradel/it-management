<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Device_model extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = [];

    // Relacion uno a muchos (inversa)
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
    // Fin Relacion uno a muchos (inversa)

    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }

    public function device_changes()
    {
        return $this->hasMany(DeviceChange::class);
    }
    // Fin Relaciones uno a muchos

    // Funcion para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {

        return LogOptions::defaults()
            ->logOnly([
                'brand->id',
                'brand->name',
                'name',
            ]);
    }
}
