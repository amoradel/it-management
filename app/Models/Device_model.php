<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device_model extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];

    // Relacion uno a muchos (inversa)
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    // Relacion uno a muchos
    public function types()
    {
        return $this->hasMany('App\Models\Type');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }

    public function device_changes()
    {
        return $this->hasMany(DeviceChange::class);
    }
}
