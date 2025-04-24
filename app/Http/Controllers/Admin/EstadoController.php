<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Muestra una lista de estados.
     */
    public function index()
    {
        $estados = Estado::paginate(10);
        return view('admin.estados.index', compact('estados'));
    }

    /**
     * Muestra el formulario para crear un nuevo estado.
     */
    public function create()
    {
        return view('admin.estados.create');
    }

    /**
     * Almacena un nuevo estado en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:estados,nombre',
                'descripcion' => 'nullable|string|max:1000',
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
        return view('admin.estados.edit', compact('estado'));
    }

    /**
     * Actualiza un estado existente en la base de datos.
     */
    public function update(Request $request, Estado $estado)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:estados,nombre,' . $estado->id,
                'descripcion' => 'nullable|string|max:1000',
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
