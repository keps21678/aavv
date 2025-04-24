<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacturaController extends Controller
{
    use SoftDeletes;
    /**
     * Muestra una lista de facturas.
     */
    public function index()
    {
        $facturas = Factura::with('proveedor')->paginate(10);
        return view('admin.facturas.index', compact('facturas'));
    }

    /**
     * Muestra el formulario para crear una nueva factura.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        return view('admin.facturas.create', compact('proveedores'));
    }

    /**
     * Almacena una nueva factura en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'numero' => 'required|string|unique:facturas,numero|max:255',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'descripcion' => 'nullable|string|max:1000', // Validación para el nuevo campo
                'importe' => 'required|numeric|min:0',
                'estado' => 'required|string|in:pendiente,pagada,vencida',
            ]);

            Factura::create($request->all());

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Factura creada correctamente',
                'text' => 'La factura se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.facturas.index')->with('success', 'Factura creada correctamente.');
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
     * Muestra el formulario para editar una factura existente.
     */
    public function edit(Factura $factura)
    {
        $proveedores = Proveedor::all();
        return view('admin.facturas.edit', compact('factura', 'proveedores'));
    }

    /**
     * Actualiza una factura existente en la base de datos.
     */
    public function update(Request $request, Factura $factura)
    {
        try {
            $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'numero' => 'required|string|unique:facturas,numero,' . $factura->id . '|max:255',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'descripcion' => 'nullable|string|max:1000', // Validación para el nuevo campo
                'importe' => 'required|numeric|min:0',
                'estado' => 'required|string|in:pendiente,pagada,vencida',
            ]);

            $factura->update($request->all());

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Factura actualizada correctamente',
                'text' => 'La factura se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.facturas.index')->with('success', 'Factura actualizada correctamente.');
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
     * Elimina una factura de la base de datos.
     */
    public function destroy(Factura $factura)
    {
        try {
            $factura->delete();

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Factura eliminada correctamente',
                'text' => 'La factura se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.facturas.index')->with('success', 'Factura eliminada correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al eliminar',
                'text' => 'No se pudo eliminar la factura. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Restaura una factura eliminada.
     */
    public function restore($id)
    {
        try {
            $factura = Factura::withTrashed()->findOrFail($id);
            $factura->restore();

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Factura restaurada correctamente',
                'text' => 'La factura se ha restaurado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.facturas.index')->with('success', 'Factura restaurada correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al restaurar',
                'text' => 'No se pudo restaurar la factura. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }
}
