<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device_model extends Model
{
    use HasFactory;
    protected $guarded = [];
    // Relacion uno a muchos (inversa)
    public function brand() {
        return $this->belongsTo('App\Models\Brand');
    }

    // Relacion uno a muchos
    public function types(){
        return $this->hasMany('App\Models\Type');
    }
}
