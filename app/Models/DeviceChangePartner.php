<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Filament\FilamentServiceProvider;

class DeviceChangePartner extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'device_change_partner';

    // Relacion muchos a muchos
    public function device_change()
    {
        return $this->belongsToMany(DeviceChange::class, 'device_change_partner_details');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_change_partner_details');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Funcion para genera los reportes
    public function generatePdf($id)
    {
        $records = DeviceChangePartner::with(['device_change', 'devices', 'partner'])->get()->where('id', $id); //Obtener los datos de la tabla segun el ID

        $pdf = PDF::loadView('pdf.pdf', compact('records'))->setPaper('letter');

        foreach ($records as $record)
        {
            $title = $title = $record->partner->name .'_' . $record->type .'_'. now()->format('d_m_Y');
        }

        return $pdf->stream($title);    
    }
}
