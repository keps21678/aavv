<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;
use Livewire\WithPagination;
use App\Models\Incidencia;
use App\Models\Socio;
use App\Models\TIncidencia;
use App\Models\Estado;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    use SoftDeletes;
    use WithPagination;

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
        $socioId = $request->input('socio_id');
        $incidencias = Incidencia::when($socioId, function ($query, $socioId) {
            return $query->where('socio_id', $socioId);
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.incidencias.index', compact('incidencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $socios = Socio::all(); // Obtener todos los socios
        $tincidencias = TIncidencia::all(); // Obtener todos los tipos de incidencia
        $estados = Estado::all(); // Obtener todos los estados
        $socioId = $request->input('socio_id'); // Obtener el socio_id si se pasa como parámetro

        return view('admin.incidencias.create', compact('socios', 'tincidencias', 'estados', 'socioId'));
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
            'estado_id' => 'required|exists:estados,id',
        ]);

        Incidencia::create($request->all());

        session()->flash('swal', [
            'title' => 'Incidencia creada correctamente',
            'text' => 'La incidencia se ha creado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.incidencias.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        $socios = Socio::all(); // Obtener todos los socios
        $tincidencias = Tincidencia::all(); // Obtener todos los tipos de incidencia
        $estados = Estado::all(); // Obtener todos los estados

        return view('admin.incidencias.edit', compact('incidencia', 'socios', 'tincidencias', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'tincidencia_id' => 'required|exists:tincidencias,id',
            'descripcion' => 'required|string|max:255',
            'fecha_incidencia' => 'required|date',
            'estado_id' => 'required|exists:estados,id',
        ]);

        $incidencia->update($request->all());

        session()->flash('swal', [
            'title' => 'Incidencia actualizada correctamente',
            'text' => 'La incidencia se ha actualizado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.incidencias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();

        session()->flash('swal', [
            'title' => 'Incidencia eliminada correctamente',
            'text' => 'La incidencia se ha eliminado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.incidencias.index', ['socio_id' => $incidencia->socio_id]);
    }
}
