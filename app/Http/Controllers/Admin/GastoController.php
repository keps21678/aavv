<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gasto;
use App\Models\Proveedor;
use App\Models\Estado; // Importación de la clase Estado
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class gastoController extends Controller
{
    use SoftDeletes;
    /**
     * Muestra una lista de gastos.
     */
    public function index()
    {
        $gastos = Gasto::with('proveedor')->paginate(10);
        return view('admin.gastos.index', compact('gastos'));
    }

    /**
     * Muestra el formulario para crear una nueva gasto.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        return view('admin.gastos.create', compact('proveedores'));
    }

    /**
     * Almacena una nueva gasto en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'numero' => 'required|string|unique:gastos,numero|max:255',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'descripcion' => 'nullable|string|max:1000',
                'importe' => 'required|numeric|min:0',
                'estado_id' => 'required|exists:estados,id', // Validación para que coincida con la clase Estado
            ]);

            Gasto::create($request->all());

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Gasto creado correctamente',
                'text' => 'El gasto se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.gastos.index')->with('success', 'Gasto creado correctamente.');
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
     * Muestra los detalles de una gasto específica.
     */
    public function show(Gasto $gasto)
    {
        return view('admin.gastos.show', compact('gasto'));
    }
    /**
     * Muestra el formulario para editar una gasto existente.
     */
    public function edit(Gasto $gasto)
    {
        $proveedores = Proveedor::all();
        $estados = Estado::all(); // Obtiene todos los estados
        return view('admin.gastos.edit', compact('gasto', 'proveedores', 'estados'));
    }

    /**
     * Actualiza una gasto existente en la base de datos.
     */
    public function update(Request $request, Gasto $gasto)
    {
        try {
            $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'numero' => 'required|string|unique:gastos,numero,' . $gasto->id . '|max:255',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'descripcion' => 'nullable|string|max:1000',
                'importe' => 'required|numeric|min:0',
                'estado_id' => 'required|exists:estados,id', // Validación para que coincida con la clase Estado
            ]);

            $gasto->update($request->all());

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Gasto actualizado correctamente',
                'text' => 'El gasto se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.gastos.index')->with('success', 'Gasto actualizado correctamente.');
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
     * Elimina una gasto de la base de datos.
     */
    public function destroy(Gasto $gasto)
    {
        try {
            $gasto->delete();

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Gasto eliminado correctamente',
                'text' => 'El gasto se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.gastos.index')->with('success', 'Gasto eliminado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al eliminar',
                'text' => 'No se pudo eliminar el gasto. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Restaura una gasto eliminada.
     */
    public function restore($id)
    {
        try {
            $gasto = Gasto::withTrashed()->findOrFail($id);
            $gasto->restore();

            // Variable de sesión Swal
            session()->flash('swal', [
                'title' => 'Gasto restaurado correctamente',
                'text' => 'El gasto se ha restaurado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.gastos.index')->with('success', 'Gasto restaurado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al restaurar',
                'text' => 'No se pudo restaurar el gasto. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    public function getTotalgastos()
    {
        $currentYear = now()->year;

        // Suma de ingresos por recibos del año en curso
        $sumagastos = Gasto::whereYear('fecha_vencimiento', $currentYear)->sum('cuota_id'); // Ajusta si `cuota_id` no es el importe
    }
}
