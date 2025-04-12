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
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'tincidencia_id' => 'required|exists:tincidencias,id',
            'descripcion' => 'required|string|max:255',
            'fecha_incidencia' => 'required|date',
        ]);

        Incidencia::create($request->all());

        return redirect()->route('admin.incidencias.index')->with('success', 'Incidencia creada correctamente.');
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
        //
        return view('admin.incidencias.edit', compact('incidencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        //
        // Eliminar la incidencia
        $incidencia->delete();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Incidencia eliminada correctamente',
            'text' => 'La incidencia se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        // Redirigir a la lista de incidencias
        return redirect()->route('admin.incidencias.index', ['socio_id' => $incidencia->socio_id]);
    }
}
