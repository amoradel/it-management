<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;

    protected $guarded = [];

    // Funcion para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name']);
    }

    //Relaciones unos a muchos
    public function models()
    {
        return $this->hasMany(DeviceModel::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function device_changes()
    {
        return $this->hasMany(DeviceChange::class);
    }
    //Fin Relaciones unos a muchos

}
