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
use Illuminate\Support\Facades\Auth;

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
        // Obtener las incidencias filtradas por socio_id si se proporciona
        $socioId = $request->input('socio_id');
        $incidencias = Incidencia::when($socioId, function ($query, $socioId) {
            return $query->where('socio_id', $socioId);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.incidencias.index', compact('incidencias'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor', 'viewer'])) {
            return redirect()->route('admin.incidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Obtener el socio, tipo de incidencia y estado relacionados con la incidencia
        $socio = $incidencia->socio; // Obtener el socio relacionado
        $tincidencia = $incidencia->tincidencia; // Obtener el tipo de incidencia relacionado
        $estado = $incidencia->estado; // Obtener el estado relacionado

        return view('admin.incidencias.show', compact('incidencia', 'socio', 'tincidencia', 'estado'));
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.incidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Obtener todos los socios, tipos de incidencia y estados
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.incidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Validar los datos de la solicitud
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.incidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Obtener todos los socios, tipos de incidencia y estados
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.incidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Validar los datos de la solicitud
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.incidencias.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Eliminar la incidencia
        $incidencia->delete();

        session()->flash('swal', [
            'title' => 'Incidencia eliminada correctamente',
            'text' => 'La incidencia se ha eliminado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.incidencias.index', ['socio_id' => $incidencia->socio_id]);
    }
}
