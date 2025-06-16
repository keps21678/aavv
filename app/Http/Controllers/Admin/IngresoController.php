<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

use App\Models\Ingreso;
use App\Models\Proveedor;
use App\Models\Estado;

class IngresoController extends Controller
{
    use SoftDeletes;
    use HasFactory;

    /**
     * Muestra una lista de ingresos, incluyendo los eliminados si es necesario.
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
        // Obtener los ingresos paginados, incluyendo los eliminados
        $ingresos = Ingreso::with('proveedor')->withTrashed()->get(); // Incluye los eliminados
        return view('admin.ingresos.index', compact('ingresos'));
    }

    /**
     * Muestra el formulario para crear un nuevo ingreso.
     */
    public function create()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.ingresos.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Obtener todos los proveedores y estados para el formulario de creación
        $proveedores = Proveedor::all();
        $estados = Estado::all();
        return view('admin.ingresos.create', compact('proveedores', 'estados'));
    }

    /**
     * Almacena un nuevo ingreso en la base de datos.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.ingresos.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Validar los datos del formulario
        try {
            $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'numero' => 'required|string|unique:ingresos,numero|max:255',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_emision',
                'descripcion' => 'nullable|string|max:1000',
                'importe' => 'required|numeric|min:0',
                'estado_id' => 'required|exists:estados,id',
            ]);

            Ingreso::create($request->all());

            session()->flash('swal', [
                'title' => 'Ingreso creado correctamente',
                'text' => 'El ingreso se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.ingresos.index')->with('success', 'Ingreso creado correctamente.');
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
     * Muestra los detalles de un ingreso específico.
     */
    public function show(Ingreso $ingreso)
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
        // Obtener el ingreso con su proveedor y estado
        return view('admin.ingresos.show', compact('ingreso'));
    }

    /**
     * Muestra el formulario para editar un ingreso existente.
     */
    public function edit(Ingreso $ingreso)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.ingresos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Obtener todos los proveedores y estados para el formulario de edición
        $proveedores = Proveedor::all();
        $estados = Estado::all();
        return view('admin.ingresos.edit', compact('ingreso', 'proveedores', 'estados'));
    }

    /**
     * Actualiza un ingreso existente en la base de datos.
     */
    public function update(Request $request, Ingreso $ingreso)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.ingresos.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Validar los datos del formulario
        try {
            $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'numero' => 'required|string|unique:ingresos,numero,' . $ingreso->id . '|max:255',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_emision',
                'descripcion' => 'nullable|string|max:1000',
                'importe' => 'required|numeric|min:0',
                'estado_id' => 'required|exists:estados,id',
            ]);

            $ingreso->update($request->all());

            session()->flash('swal', [
                'title' => 'Ingreso actualizado correctamente',
                'text' => 'El ingreso se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.ingresos.index')->with('success', 'Ingreso actualizado correctamente.');
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
     * Elimina un ingreso de la base de datos.
     */
    public function destroy(Ingreso $ingreso)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.ingresos.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Eliminar el ingreso
        try {
            $ingreso->delete();

            session()->flash('swal', [
                'title' => 'Ingreso eliminado correctamente',
                'text' => 'El ingreso se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al eliminar',
                'text' => 'No se pudo eliminar el ingreso. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Restaura un ingreso eliminado.
     */
    public function restore($id)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.ingresos.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Restaurar el ingreso eliminado
        try {
            $ingreso = Ingreso::withTrashed()->findOrFail($id);
            $ingreso->restore();

            session()->flash('swal', [
                'title' => 'Ingreso restaurado correctamente',
                'text' => 'El ingreso se ha restaurado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.ingresos.index')->with('success', 'Ingreso restaurado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al restaurar',
                'text' => 'No se pudo restaurar el ingreso. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Obtiene el total de ingresos del año en curso.
     */
    public function getTotalIngresos()
    {
        $currentYear = now()->year;

        $sumaIngresos = Ingreso::whereYear('fecha_vencimiento', $currentYear)->sum('importe');

        return $sumaIngresos;
    }
}
