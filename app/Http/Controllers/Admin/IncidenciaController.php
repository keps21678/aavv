<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\Socio;
use App\Models\TIncidencia;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class IncidenciaController extends Controller
{
    use withPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el socio_id desde la solicitud (si se proporciona)
        $socioId = $request->input('socio_id');

        // Buscar incidencias según el socio_id
        $incidencias = Incidencia::when($socioId, function ($query, $socioId) {
            return $query->where('socio_id', $socioId);
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Verificar si no se encontraron incidencias
        if ($incidencias->isEmpty()) {
            session()->flash('swal', [
                'title' => 'No se encontraron incidencias',
                'text' => 'No se encontraron incidencias para el socio especificado',
                'icon' => 'info',
            ]);
        }

        // Pasar las incidencias a la vista
        return view('admin.incidencias.index', compact('incidencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $socios = Socio::all();
        $tincidencias = TIncidencia::all();
        $socioId = $request->input('socio_id'); // Captura el socio_id de la URL

        return view('admin.incidencias.create', compact('socios', 'tincidencias', 'socioId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de la solicitud
            $request->validate([
                'socio_id' => 'required|exists:socios,id',
                'socio_id' => function ($attribute, $value, $fail) {
                    if (!Socio::find($value)) {
                        $fail('El socio especificado no existe.');
                    }
                },
                'tincidencia_id' => 'required|exists:tincidencias,id',
                'tincidencia_id' => function ($attribute, $value, $fail) {
                    if (!TIncidencia::find($value)) {
                        $fail('El tipo de incidencia especificado no existe.');
                    }
                },
                'descripcion' => 'required|string|max:255',
                'fecha_incidencia' => 'required|date',
            ]);

            // Crear la incidencia
            Incidencia::create($request->all());

            // Mensaje de éxito
            session()->flash('swal', [
                'title' => 'Incidencia creada correctamente',
                'text' => 'La incidencia se ha creado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.incidencias.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mensaje de error de validación
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, revise los campos e intente nuevamente.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Mensaje de error genérico
            session()->flash('swal', [
                'title' => 'Error',
                'text' => 'Ocurrió un error al intentar crear la incidencia.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        // Obtener todos los socios y tipos de incidencia
        $socios = Socio::all();
        $tincidencias = TIncidencia::all();

        // Pasar los datos a la vista
        return view('admin.incidencias.edit', compact('incidencia', 'socios', 'tincidencias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        try {
            // Validar los datos de la solicitud
            $request->validate([
                'socio_id' => [
                    'required',
                    'exists:socios,id',
                    function ($attribute, $value, $fail) {
                        if (!Socio::find($value)) {
                            $fail('El socio especificado no existe.');
                        }
                    },
                ],
                'tincidencia_id' => [
                    'required',
                    'exists:tincidencias,id',
                    function ($attribute, $value, $fail) {
                        if (!TIncidencia::find($value)) {
                            $fail('El tipo de incidencia especificado no existe.');
                        }
                    },
                ],
                'descripcion' => 'required|string|max:255',
                'fecha_incidencia' => 'required|date',
            ]);

            // Actualizar la incidencia
            $incidencia->update($request->all());

            // Mensaje de éxito
            session()->flash('swal', [
                'title' => 'Incidencia actualizada correctamente',
                'text' => 'La incidencia se ha actualizado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.incidencias.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mensaje de error de validación
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, revise los campos e intente nuevamente.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Mensaje de error genérico
            session()->flash('swal', [
                'title' => 'Error',
                'text' => 'Ocurrió un error al intentar actualizar la incidencia.',
                'icon' => 'error',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        try {
            // Eliminar la incidencia
            $incidencia->delete();

            // Mensaje de éxito
            session()->flash('swal', [
                'title' => 'Incidencia eliminada correctamente',
                'text' => 'La incidencia se ha eliminado correctamente.',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.incidencias.index', ['socio_id' => $incidencia->socio_id]);
        } catch (\Exception $e) {
            // Mensaje de error genérico
            session()->flash('swal', [
                'title' => 'Error',
                'text' => 'Ocurrió un error al intentar eliminar la incidencia.',
                'icon' => 'error',
            ]);

            return redirect()->route('admin.incidencias.index');
        }
    }
}
