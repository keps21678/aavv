<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TSocio;
use Illuminate\Http\Request;

class TSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tsocios = TSocio::orderBy('id', 'asc')->get();

        return view('admin.tsocios.index', compact('tsocios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tsocios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string|min:5|max:255',
            'descripcion' => 'required|string|min:5|max:255',
        ]);
        TSocio::create($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de socio/a creado correctamente',
            'text' => 'El Tipo de socio/a se ha creado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tsocios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TSocio $tSocio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TSocio $tsocio)
    {
        //
        return view('admin.tsocios.edit', compact('tsocio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TSocio $tsocio)
    {
        //
        $request->validate([
            'nombre' => 'required|string|min:5|max:255',
            'descripcion' => 'required|string|min:5|max:255',
        ]);
        // Actualizar el registro utilizando los datos validados        
        $tsocio->update($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de socio/a actualizado correctamente',
            'text' => 'El Tipo de socio/a se ha actualizado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tsocios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TSocio $tsocio)
    {
        //        
        if ($tsocio->socios()->count() > 0) {
            // Verificar si el tipo de socio/a tiene usuarios asociados
            session()->flash('swal', [
                'title' => 'Error al eliminar el Tipo de socio/a',
                'text' => 'El Tipo de socio/a no se puede eliminar porque tiene socios/as asociados',
                'icon' => 'error',
            ]);
            return redirect()->route('admin.tsocios.index');
        } 
        else {
            // Borrado del socio/a
            $tsocio->delete();
            // variable de sesión
            session()->flash('swal', [
                'title' => 'Tipo de socio eliminado correctamente',
                'text' => 'El Tipo de socio se ha eliminado correctamente',
                'icon' => 'success',
            ]);
            return redirect()->route('admin.tsocios.index');
        }
    }
}
