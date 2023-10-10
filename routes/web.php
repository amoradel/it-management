<?php

use App\Models\DeviceChangePartner;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Illuminate\Support\Facades\App;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('download/{id}', function ($id) {
//     $records = DeviceChangePartner::all(); //Obtener los datos de la tabla segun el ID

//     $pdf = Pdf::loadView('pdf.pdf', compact('records')); //Cargar vista del pdf con los datos
//     return $pdf->stream();
// })->name('download_pdf');

Route::get('download/{id}', 'App\Models\DeviceChangePartner@generatePdf')->name('download_pdf');
