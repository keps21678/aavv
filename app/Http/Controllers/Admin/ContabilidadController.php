<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Recibo;

class ContabilidadController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;

        // Suma de importes y número de recibos del año en curso
        $sumaRecibos = Recibo::whereYear('fecha_vencimiento', $currentYear)->sum('cuota_id'); // Cambia 'cuota_id' si es necesario
        $numeroRecibos = Recibo::whereYear('fecha_vencimiento', $currentYear)->count();

        // Suma de importes y número de facturas del año en curso
        $sumaFacturas = Factura::whereYear('fecha_vencimiento', $currentYear)->sum('importe');
        $numeroFacturas = Factura::whereYear('fecha_vencimiento', $currentYear)->count();

        return view('admin.contabilidad.index', compact('sumaRecibos', 'numeroRecibos', 'sumaFacturas', 'numeroFacturas'));
    }
}
