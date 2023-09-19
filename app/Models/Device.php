<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relacion uno a muchos (inversa)
    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }

    public function model(){
        return $this->belongsTo('App\Models\Device_model');
    }

    public function type(){
        return $this->belongsTo('App\Models\Type');
    }

    public function department(){
        return $this->belongsTo('App\Models\Department');
    }

    // Relacion muchos a muchos
    public function partners(){
        return $this->belongsToMany('App\Models\Partner', 'device_partner')->withTimestamps();
    }
}
