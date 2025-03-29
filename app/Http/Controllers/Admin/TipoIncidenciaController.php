<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoIncidencia;
use Illuminate\Http\Request;

class TipoIncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tiposIncidencias = TipoIncidencia::all()->sortBy('id');
        return view('admin.tiposincidencias.index', compact('tiposIncidencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tiposincidencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:5|max:255',
        ]);
        TipoIncidencia::create($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de incidencia creada correctamente',
            'text' => 'El tipo de incidencia se ha creado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tiposincidencias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoIncidencia $tipoIncidencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoIncidencia $tipoIncidencia)
    {
        //        
        return view('admin.tiposincidencias.edit', compact('tipoIncidencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoIncidencia $tipoIncidencia)
    {
        //
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:5|max:255',
        ]);
        $tipoIncidencia->update($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de incidencia actualizada correctamente',
            'text' => 'El tipo de incidencia se ha actualizado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tiposincidencias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoIncidencia $tipoIncidencia)
    {
        //
        $tipoIncidencia->delete();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de incidencia eliminada correctamente',
            'text' => 'El tipo de incidencia se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tiposincidencias.index');
    }
}
