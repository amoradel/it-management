<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    // protected $fillable = ['name'];
    protected $guarded = [];

    //Relacion unos a muchos
    public function models()
    {
        return $this->hasMany(Device_model::class);
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }

    public function types(){
        return $this->hasMany('App\Models\Type');
    }
}
