<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstadoController extends Controller
{
    /**
     * Muestra una lista de estados.
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
        // Obtener todos los estados ordenados por ID
        $estados = Estado::all()->sortBy('id');
        return view('admin.estados.index', compact('estados'));
    }

    /**
     * Muestra el formulario para crear un nuevo estado.
     */
    public function create()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.estados.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Mostrar el formulario de creación de estado
        return view('admin.estados.create');
    }

    /**
     * Almacena un nuevo estado en la base de datos.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.estados.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }

        // Validar los datos del formulario
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:estados,nombre',
                'descripcion' => 'nullable|string|max:1000',
                'color' => 'nullable|string|max:7',
            ]);

            Estado::create($request->all());

            session()->flash('swal', [
                'title' => 'Estado creado correctamente',
                'text' => 'El estado se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.estados.index')->with('success', 'Estado creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, corrige los errores e inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Muestra el formulario para editar un estado existente.
     */
    public function edit(Estado $estado)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.estados.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        
        return view('admin.estados.edit', compact('estado'));
    }

    /**
     * Actualiza un estado existente en la base de datos.
     */
    public function update(Request $request, Estado $estado)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.estados.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Validar los datos del formulario
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:estados,nombre,' . $estado->id,
                'descripcion' => 'nullable|string|max:1000',
                'color' => 'nullable|string|max:7',                
            ]);

            $estado->update($request->all());

            session()->flash('swal', [
                'title' => 'Estado actualizado correctamente',
                'text' => 'El estado se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.estados.index')->with('success', 'Estado actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, corrige los errores e inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Elimina un estado de la base de datos.
     */
    public function destroy(Estado $estado)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.estados.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        
        try {
            $estado->delete();

            session()->flash('swal', [
                'title' => 'Estado eliminado correctamente',
                'text' => 'El estado se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.estados.index')->with('success', 'Estado eliminado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al eliminar',
                'text' => 'No se pudo eliminar el estado. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Restaura un estado eliminado.
     */
    public function restore($id)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.estados.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }

        try {
            $estado = Estado::withTrashed()->findOrFail($id);
            $estado->restore();

            session()->flash('swal', [
                'title' => 'Estado restaurado correctamente',
                'text' => 'El estado se ha restaurado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.estados.index')->with('success', 'Estado restaurado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al restaurar',
                'text' => 'No se pudo restaurar el estado. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }
}
