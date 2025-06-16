<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Models\Recibo;
use App\Models\Ingreso;

class ContabilidadController extends Controller
{
    public function index()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor', 'viewer'])) {
            return redirect()->route('dashboard')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Obtener el año actual
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor', 'viewer'])) {
            return redirect()->route('dashboard')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Obtener todos los recibos
        $recibo = Recibo::all();
        // Verifica si el recibo pertenece al usuario autenticado
        $gasto  = Gasto::all();
        $ingreso = Ingreso::all();
        return view('admin.contabilidad.show', compact('recibo', 'gasto', 'ingreso'));
    }
}
