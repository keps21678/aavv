<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibo;
use App\Models\Socio;
use App\Models\Cuota;
use App\Models\Estado;
use App\Models\Tsocio;
use App\Exports\RecibosExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    /**
     * Muestra el formulario para ver un recibo específico.
     */
    public function show (Recibo $recibo)
    {
        return view('admin.recibos.show', compact('recibo'));
    }
    
    /**
     * Muestra una lista de recibos.
     */
    public function index()
    {
        $recibos = Recibo::with(['socio', 'cuota', 'tsocio'])->get();
        return view('admin.recibos.index', compact('recibos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recibo.
     */
    public function create()
    {
        $socios = Socio::all();
        $cuotas = Cuota::all();
        $tsocios = Tsocio::all();
        $estados = Estado::all(); // Asegúrate de que el modelo Estado existe y está configurado correctamente
        return view('admin.recibos.create', compact('socios', 'cuotas', 'tsocios', 'estados'));
    }

    /**
     * Almacena un nuevo recibo en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'socio_id' => 'required|exists:socios,id',
                'tsocio_id' => 'required|exists:cuotas,id',
                'cuota_id' => 'required|numeric|min:0',
                'recibo_numero' => 'nullable|string|max:255|unique:recibos,recibo_numero', // Validación para el número de recibo único
                // Asegúrate de que el número de recibo sea único en la tabla recibos
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'estado_id' => 'required|exists:estados,id', // Validación para que coincida con la tabla estados
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
            $errors = $e->getMessage();

            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => $errors,
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
        $estados = Estado::all();
        $tsocios = Tsocio::all();
        return view('admin.recibos.edit', compact('recibo', 'socios', 'cuotas', 'estados', 'tsocios'));
    }

    /**
     * Actualiza un recibo existente en la base de datos.
     */
    public function update(Request $request, Recibo $recibo)
    {
        try {
            $request->validate([
                'socio_id' => 'required|exists:socios,id',
                'tsocio_id' => 'required|exists:cuotas,id',
                'cuota_id' => 'required|numeric|min:0',
                'recibo_numero' => 'nullable|string|max:255|unique:recibos,recibo_numero,' . $recibo->id, // Validación para el número de recibo único
                // Asegúrate de que el número de recibo sea único en la tabla recibos
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
                'estado_id' => 'required|exists:estados,id', // Validación para que coincida con la tabla estados
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
            $errors = $e->getMessage();

            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => $errors,
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
            $errors = $e->getMessage();

            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => $errors,
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
            $errors = $e->getMessage();

            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => $errors,
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }

    /**
     * Genera una remesa de recibos y exporta un archivo Excel.
     */
    public function generarRemesa()
    {
        try {
            // Obtener el año en curso
            $currentYear = now()->year;

            // Obtener los socios con domiciliación activa
            $socios = Socio::with('cuota')
                ->where('domiciliacion', true)
                ->get();

            // Guardar los datos en la tabla recibos
            foreach ($socios as $socio) {
                // Verificar si ya existe un recibo para el socio y el año en curso
                $reciboExistente = Recibo::where('socio_id', $socio->id)
                    ->whereYear('fecha_emision', $currentYear)
                    ->exists();

                if ($reciboExistente) {
                    // Si ya existe, omitir la creación del recibo
                    continue;
                }

                // Crear el recibo si no existe
                Recibo::create([
                    'socio_id' => $socio->id,
                    'cuota_id' => $socio->cuota->id ?? null,
                    'tsocio_id' => $socio->tsocio->id ?? null, // Incluye el campo tsocio_id
                    'recibo_numero' => 'REC-' . now()->timestamp . '-' . $socio->id,
                    'fecha_emision' => now(),
                    'fecha_vencimiento' => now()->addDays(30), // Ejemplo: 30 días después de la emisión
                    'estado_id' => Estado::where('nombre', 'Pendiente')->first()->id ?? null, // Estado predeterminado
                    'descripcion' => 'Cuota ' . ($socio->cuota->anyo ?? 'N/A'),
                ]);
            }

            // Exportar el archivo Excel
            return Excel::download(new RecibosExport, 'remesa_recibos.xlsx');
        } catch (\Exception $e) {
            session()->flash('swal', [
                'title' => 'Error al generar la remesa',
                'text' => $e->getMessage(),
                'icon' => 'error',
            ]);

            return redirect()->back();
        }
    }
    
    public function getTotalRecibos()
    {
        $currentYear = now()->year;

        // Suma de importes de facturas del año en curso
        $sumaRecibos = Recibo::whereYear('fecha_vencimiento', $currentYear)->sum('importe');      
    }
}
