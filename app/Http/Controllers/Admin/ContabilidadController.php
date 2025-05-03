<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Models\Recibo;
use App\Models\Ingreso;

class ContabilidadController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;

        // Suma de importes y número de recibos del año en curso
        $sumaRecibos = Recibo::whereYear('fecha_vencimiento', $currentYear)->sum('cuota_id'); // Cambia 'cuota_id' si es necesario
        $numeroRecibos = Recibo::whereYear('fecha_vencimiento', $currentYear)->count();

        // Suma de importes y número de gastos del año en curso
        $sumaGastos = Gasto::whereYear('fecha_vencimiento', $currentYear)->sum('importe');
        $numeroGastos = Gasto::whereYear('fecha_vencimiento', $currentYear)->count();

        // Suma de importes y número de ingresos del año en curso
        $numeroIngresos = Ingreso::whereYear('fecha_vencimiento', $currentYear)->count();
        $sumaIngresos = Ingreso::whereYear('fecha_vencimiento', $currentYear)->sum('importe');

        return view('admin.contabilidad.index', compact('sumaRecibos', 'numeroRecibos', 'sumaGastos', 'numeroGastos', 'numeroIngresos', 'sumaIngresos'));
    }
    /**
     * Display the specified resource.
     */
    public function show()
    {
        //    
        $recibo = Recibo::all();
        // Verifica si el recibo pertenece al usuario autenticado
        $gasto  = Gasto::all();
        $ingreso = Ingreso::all();
        return view('admin.contabilidad.show', compact('recibo', 'gasto', 'ingreso'));
    }
}
