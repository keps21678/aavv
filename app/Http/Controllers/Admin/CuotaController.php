<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuota;
use App\Models\TSocio;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Obtener todas las cuotas
        //$cuotas = Cuota::orderBy('created_at', 'desc')->paginate(10);
        $cuotas = Cuota::with('tsocio')
            ->orderBy('created_at', 'desc')
            ->get(); // Carga la relación tsocio
        // Verificar si no se encontraron cuotas
        if ($cuotas->isEmpty()) {
            session()->flash('swal', [
                'title' => 'No se encontraron cuotas',
                'text' => 'No se encontraron cuotas con los criterios de búsqueda proporcionados',
                'icon' => 'info',
            ]);
        }
        // Pasar las cuotas a la vista
        return view('admin.cuotas.index', compact('cuotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $tsocios = TSocio::orderBy('id', 'desc')->get();
        // Crear una nueva cuota
        $cuota = new Cuota();
        $cuota->cantidad = 0;
        return view('admin.cuotas.create', compact('cuota', 'tsocios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de la solicitud
            $request->validate([
                'tsocio_id' => 'required|integer|exists:tsocios,id',
                'anyo' => 'required|integer|min:1950|max:3000',
                'cantidad' => 'required|numeric|min:0',
            ]);
            // Verificar si la cuota ya existe  
            $existingCuota = Cuota::where('tsocio_id', $request->input('tsocio_id'))
                ->where('anyo', $request->input('anyo'))
                ->first();
            if ($existingCuota) {
                // Mensaje de error
                session()->flash('swal', [
                    'title' => 'Error',
                    'text' => 'La cuota ya existe para este tipo de socio y año.',
                    'icon' => 'error',
                ]);

                return redirect()->back()->withInput();
            } else {
                // Crear una nueva cuota
                Cuota::create([
                    'tsocio_id' => $request->input('tsocio_id'),
                    'anyo' => $request->input('anyo'),
                    'cantidad' => $request->input('cantidad'),
                ]);
                // Mensaje de éxito
                session()->flash('swal', [
                    'title' => 'Cuota creada correctamente',
                    'text' => 'La cuota se ha creado correctamente.',
                    'icon' => 'success',
                ]);

                return redirect()->route('admin.cuotas.index');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mensaje de error de validación
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, revise los campos e intente nuevamente.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Mensaje de error genérico
            session()->flash('swal', [
                'title' => 'Error',
                'text' => 'Ocurrió un error al intentar guardar la cuota.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuota $cuota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuota $cuota)
    {
        // 
        // Obtener los tipos de socio
        $tsocios = TSocio::orderBy('id', 'desc')->get();
        // Editar una cuota
        return view('admin.cuotas.edit', compact('cuota', 'tsocios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuota $cuota)
    {
        try {
            // Validar los datos de la solicitud con mensajes personalizados
            $request->validate([
                'tsocio_id' => 'required|integer|exists:tsocios,id',
                'anyo' => 'required|integer|min:1950|max:3000',
                'cantidad' => 'required|numeric|min:0',
            ], [
                'tsocio_id.required' => 'El campo Tipo de Socio es obligatorio.',
                'tsocio_id.integer' => 'El campo Tipo de Socio debe ser un número entero.',
                'tsocio_id.exists' => 'El Tipo de Socio seleccionado no es válido.',
                'anyo.required' => 'El campo Año es obligatorio.',
                'anyo.integer' => 'El campo Año debe ser un número entero.',
                'anyo.min' => 'El campo Año debe ser mayor o igual a 1950.',
                'anyo.max' => 'El campo Año debe ser menor o igual a 3000.',
                'cantidad.required' => 'El campo Cantidad es obligatorio.',
                'cantidad.numeric' => 'El campo Cantidad debe ser un número.',
                'cantidad.min' => 'El campo Cantidad debe ser mayor o igual a 0.',
            ]);

            // Actualizar la cuota
            $cuota->update([
                'tsocio_id' => $request->input('tsocio_id'),
                'anyo' => $request->input('anyo'),
                'cantidad' => $request->input('cantidad'),
            ]);

            // Redirigir a la lista de cuotas con un mensaje de éxito
            session()->flash('swal', [
                'title' => 'Cuota actualizada',
                'text' => 'La cuota se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.cuotas.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mensaje de error de validación
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, revise los campos e intente nuevamente.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Mensaje de error genérico
            session()->flash('swal', [
                'title' => 'Error',
                'text' => 'Ocurrió un error al intentar actualizar la cuota.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuota $cuota)
    {
        // Eliminar la cuota
        $cuota->delete();
        // Redirigir a la lista de cuotas con un mensaje de éxito
        session()->flash('swal', [
            'title' => 'Cuota eliminada',
            'text' => 'La cuota se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.cuotas.index');
    }
}
