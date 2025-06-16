<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tincidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TincidenciaController extends Controller
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
        // Obtener todos los tipos de incidencias
        $tincidencias = Tincidencia::orderBy('id', 'asc')->get();

        return view('admin.tincidencias.index', compact('tincidencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.tincidencias.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Mostrar el formulario para crear un nuevo tipo de incidencia
        return view('admin.tincidencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.tincidencias.index')
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
        Tincidencia::create($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de incidencia creado correctamente',
            'text' => 'El Tipo de incidencia se ha creado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tincidencias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tincidencia $tincidencia)
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
    public function edit(Tincidencia $tincidencia)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.tincidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Mostrar el formulario para editar el tipo de incidencia
        return view('admin.tincidencias.edit', compact('tincidencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tincidencia $tincidencia)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.tincidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        $request->validate([
            'nombre' => 'required|string|min:5|max:255',
            'descripcion' => 'required|string|min:5|max:255',
        ]);
        // Actualizar el registro utilizando los datos validados        
        $tincidencia->update($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Tipo de incidencia actualizado correctamente',
            'text' => 'El Tipo de incidencia se ha actualizado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.tincidencias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tincidencia $tincidencia)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.tincidencias.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Verificar si el tipo de incidencia existe
        try {
            // Verificar si el tipo de incidencia está asociado a alguna incidencia
            if ($tincidencia->incidencias()->exists()) {
                // Mensaje de error si el tipo de incidencia está en uso
                session()->flash('swal', [
                    'title' => 'Error',
                    'text' => 'No se puede eliminar el tipo de incidencia porque está asociado a una o más incidencias.',
                    'icon' => 'error',
                ]);

                return redirect()->route('admin.tincidencias.index');
            }

            // Eliminar el tipo de incidencia
            $tincidencia->delete();

            // Mensaje de éxito
            session()->flash('swal', [
                'title' => 'Tipo de incidencia eliminado correctamente',
                'text' => 'El Tipo de incidencia se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.tincidencias.index');
        } catch (\Exception $e) {
            // Mensaje de error genérico
            session()->flash('swal', [
                'title' => 'Error',
                'text' => 'Ocurrió un error al intentar eliminar el tipo de incidencia.',
                'icon' => 'error',
            ]);

            return redirect()->route('admin.tincidencias.index');
        }
    }
}
