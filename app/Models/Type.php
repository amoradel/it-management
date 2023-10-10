<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Type extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $guarded = [];

    // Relaciones uno a muchos (inversa)
    public function model()
    {
        return $this->belongsTo('App\Models\Device_model');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
    // Fin Relaciones uno a muchos (inversa)

    // Relaciones uno a muchos
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
                'model->id',
                'model->name',
                'name'
            ]);
    }
}
