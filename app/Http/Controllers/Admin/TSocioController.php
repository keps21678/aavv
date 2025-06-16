<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TSocio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        // Obtener todos los tipos de socios
        $tsocios = TSocio::orderBy('id', 'asc')->get();

        return view('admin.tsocios.index', compact('tsocios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.tsocios.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Mostrar el formulario para crear un nuevo tipo de socio
        return view('admin.tsocios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.tsocios.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Validar los datos de entrada
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TSocio $tsocio)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.tsocios.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        //
        return view('admin.tsocios.edit', compact('tsocio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TSocio $tsocio)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.tsocios.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.tsocios.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Verificar si el tipo de socio/a tiene usuarios asociados
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
