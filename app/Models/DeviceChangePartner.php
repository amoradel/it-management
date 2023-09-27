<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

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

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Funcion para genera los reportes
    public function generatePdf($id)
    {
        // $dompdf = new Dompdf();
        // $options = config('dompdf');
        // $dompdf->setOptions($options);
    
        $records = DeviceChangePartner::with(['device_change', 'device', 'partner'])->get()->where('id', $id); //Obtener los datos de la tabla segun el ID
        // $pdf = PDF::loadView('pdf.pdf', compact('records'));
        // $pdf = PDF::setPaper('letter', 'landscape');
        $pdf = PDF::loadView('pdf.pdf', compact('records'))->setPaper('letter' );

        return $pdf->stream();    }
}
