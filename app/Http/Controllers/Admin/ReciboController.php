<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibo;
use App\Models\Socio;
use App\Models\Cuota;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    /**
     * Muestra una lista de recibos.
     */
    public function index()
    {
        $recibos = Recibo::with(['socio', 'cuota'])->paginate(10);
        return view('admin.recibos.index', compact('recibos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recibo.
     */
    public function create()
    {
        $socios = Socio::all();
        $cuotas = Cuota::all();
        return view('admin.recibos.create', compact('socios', 'cuotas'));
    }

    /**
     * Almacena un nuevo recibo en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'socio_id' => 'required|exists:socios,id',
                'cuota_id' => 'required|exists:cuotas,id',
                'importe' => 'required|numeric|min:0',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'estado' => 'required|string|in:pendiente,pagado,vencido',
                'descripcion' => 'nullable|string|max:1000',
            ]);

            Recibo::create($request->all());

            session()->flash('swal', [
                'title' => 'Recibo creado correctamente',
                'text' => 'El recibo se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.recibos.index')->with('success', 'Recibo creado correctamente.');
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
     * Muestra el formulario para editar un recibo existente.
     */
    public function edit(Recibo $recibo)
    {
        $socios = Socio::all();
        $cuotas = Cuota::all();
        return view('admin.recibos.edit', compact('recibo', 'socios', 'cuotas'));
    }

    /**
     * Actualiza un recibo existente en la base de datos.
     */
    public function update(Request $request, Recibo $recibo)
    {
        try {
            $request->validate([
                'socio_id' => 'required|exists:socios,id',
                'cuota_id' => 'required|exists:cuotas,id',
                'importe' => 'required|numeric|min:0',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'estado' => 'required|string|in:pendiente,pagado,vencido',
                'descripcion' => 'nullable|string|max:1000',
            ]);

            $recibo->update($request->all());

            session()->flash('swal', [
                'title' => 'Recibo actualizado correctamente',
                'text' => 'El recibo se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.recibos.index')->with('success', 'Recibo actualizado correctamente.');
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
     * Elimina un recibo de la base de datos.
     */
    public function destroy(Recibo $recibo)
    {
        try {
            $recibo->delete();

            session()->flash('swal', [
                'title' => 'Recibo eliminado correctamente',
                'text' => 'El recibo se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.recibos.index')->with('success', 'Recibo eliminado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al eliminar',
                'text' => 'No se pudo eliminar el recibo. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Restaura un recibo eliminado.
     */
    public function restore($id)
    {
        try {
            $recibo = Recibo::withTrashed()->findOrFail($id);
            $recibo->restore();

            session()->flash('swal', [
                'title' => 'Recibo restaurado correctamente',
                'text' => 'El recibo se ha restaurado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.recibos.index')->with('success', 'Recibo restaurado correctamente.');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al restaurar',
                'text' => 'No se pudo restaurar el recibo. Inténtalo de nuevo.',
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }
}
