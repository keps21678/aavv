<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Muestra una lista de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::paginate(10); // Paginación de 10 elementos
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Almacena un nuevo proveedor en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $this->validateProveedor($request);

            Proveedor::create($request->all());

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Proveedor creado correctamente',
                'text' => 'El proveedor se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->map(function ($messages, $field) {
                return ucfirst($field) . ': ' . implode(', ', $messages);
            })->implode("\n");

            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => $errors,
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Muestra el formulario para editar un proveedor existente.
     */
    public function edit(Proveedor $proveedor)
    {
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualiza un proveedor existente en la base de datos.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        try {
            $this->validateProveedor($request);

            $proveedor->update($request->all());

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Proveedor actualizado correctamente',
                'text' => 'El proveedor se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->map(function ($messages, $field) {
                return ucfirst($field) . ': ' . implode(', ', $messages);
            })->implode("\n");

            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => $errors,
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Elimina un proveedor de la base de datos.
     */
    public function destroy(Proveedor $proveedor)
    {
        try {
            $proveedor->delete();

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Proveedor eliminado correctamente',
                'text' => 'El proveedor se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al eliminar',
                'text' => 'No se pudo eliminar el proveedor. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Valida los datos del proveedor.
     */
    private function validateProveedor(Request $request)
    {
        $request->validate([
            'nif' => 'required|string|max:9',
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'calle' => 'nullable|string|max:255',
            'portal' => 'nullable|string|max:10',
            'piso' => 'nullable|string|max:10',
            'letra' => 'nullable|string|max:1',
            'codigo_postal' => 'nullable|string|max:10',
            'poblacion' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'persona_contacto' => 'nullable|string|max:255',
            'domiciliacion' => 'boolean',
            'iban' => 'nullable|string',
            'titular' => 'nullable|string|max:255',
            'dni_titular' => 'nullable|string|max:9',
        ]);
    }
}
