<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'attached_img' => 'array',
    ];

    // Función para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'state',
                'partner_id',
                'device_id',
            ]);
    }

    // Relaciones uno a muchos
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
