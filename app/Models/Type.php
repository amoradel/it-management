<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relacion uno a muchos (inversa)
    public function model()
    {
        return $this->belongsTo('App\Models\Device_model');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    // Relacion uno a muchos
    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }

    public function device_changes()
    {
        return $this->hasMany(DeviceChange::class);
    }
}
