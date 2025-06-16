<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gasto;
use App\Models\Proveedor;
use App\Models\Estado; // Importación de la clase Estado
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    use SoftDeletes;
    /**
     * Muestra una lista de gastos.
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
        // Obtener los gastos con sus proveedores y paginarlos            
        $gastos = Gasto::with('proveedor')->get();
        return view('admin.gastos.index', compact('gastos'));
    }

    /**
     * Muestra el formulario para crear una nueva gasto.
     */
    public function create()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.gastos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Cargar los proveedores y estados para el formulario de creación
        $proveedores = Proveedor::all();
        $estados = Estado::all(); // Obtiene todos los estados
        return view('admin.gastos.create', compact('proveedores', 'estados')); // <--- AÑADE 'estados' aquí
    }

    /**
     * Almacena una nueva gasto en la base de datos.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.gastos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Cargar el proveedor relacionado con el gasto
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
        // Cargar el proveedor relacionado con el gasto
        return view('admin.gastos.show', compact('gasto'));
    }
    /**
     * Muestra el formulario para editar una gasto existente.
     */
    public function edit(Gasto $gasto)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.gastos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Cargar el proveedor relacionado con el gasto
        $proveedores = Proveedor::all();
        $estados = Estado::all(); // Obtiene todos los estados
        return view('admin.gastos.edit', compact('gasto', 'proveedores', 'estados'));
    }

    /**
     * Actualiza una gasto existente en la base de datos.
     */
    public function update(Request $request, Gasto $gasto)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.gastos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Cargar el proveedor relacionado con el gasto
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.gastos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Elimina el gasto de la base de datos
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.gastos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Restaura el gasto eliminado
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
