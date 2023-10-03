<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Department extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = [];

    // Relaciones uno a muchos
    public function partners()
    {
        return $this->hasMany('App\Models\Partner');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }
    // Fin Relaciones uno a muchos

    // Funcion para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
            ]);
    }
}
