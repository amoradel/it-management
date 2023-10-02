<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    //Relaciones unos a muchos
    public function models()
    {
        return $this->hasMany(Device_model::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    public function device_changes()
    {
        return $this->hasMany(DeviceChange::class);
    }
    //Relaciones unos a muchos

}
