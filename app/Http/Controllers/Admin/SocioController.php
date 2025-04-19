<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class SocioController extends Controller
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
    public function index()
    {
        // Obtener los socios segun la busqueda, necesario pasara a la vista
        // de LiveWire
        $socios = Socio::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('apellidos', 'LIKE', '%' . $this->search . '%')
            ->orderBy('nsocio', 'asc')
            ->withCount('incidencias')
            ->paginate(8);
        //$socios = Socio::withCount('incidencias')->paginate(10); // Carga el conteo de incidencias

        if ($socios->isEmpty()) {
            session()->flash('swal', [
                'title' => 'No se encontraron socios',
                'text' => 'No se encontraron socios con los criterios de búsqueda proporcionados',
                'icon' => 'info',
            ]);
        }
        // $users = User::orderBy('id', 'desc')->get();
        // Obtener todos los usuarios con sus roles
        // $users = User::with('roles')->orderBy('id', 'asc')->get();

        // Pasar los usuarios a la vista
        return view('admin.socios.index', compact('socios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $socio = new Socio();
        return view('admin.socios.create', compact('socio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:socios,dni',
            'telefono' => 'nullable|string|max:20',
            'movil' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'calle' => 'nullable|string|max:255',
            'portal' => 'nullable|string|max:10',
            'piso' => 'nullable|string|max:10',
            'letra' => 'nullable|string|max:5',
            'codigo_postal' => 'nullable|string|max:10',
            'poblacion' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'empresa' => 'boolean',
            'baja' => 'boolean',
            'domiciliacion' => 'boolean',
        ]);

        Socio::create($validatedData);

        return redirect()->route('admin.socios.index')->with('success', 'Socio creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Socio $socio)
    {
        //
        return view('admin.socios.show', compact('socio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Socio $socio)
    {
        //
        return view('admin.socios.edit', compact('socio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Socio $socio)
    {
        try {
            // Verificar si el campo 'baja' es true
            if ($request->input('baja')) {
                // Realizar alguna acción específica si el socio está dado de baja                
                $socio->incidencias()->create([
                    'descripcion' => 'Baja',
                    'fecha_incidencia' => now(),
                    'tincidencia_id' => \App\Models\Tincidencia::where('descripcion', 'Baja')->value('id'), // Buscar el ID de la incidencia según la descripción
                    'socio_id' => $socio->id,
                ]); // Generar una incidencia con el texto "Baja"
                $request->merge(['baja' => true]); // Asegurarse de que 'baja' sea true
            } else {
                $socio->incidencias()->create([
                    'descripcion' => 'Alta, tras una baja',
                    'fecha_incidencia' => now(),
                    'tincidencia_id' => \App\Models\Tincidencia::where('descripcion', 'Alta')->value('id'), // Buscar el ID de la incidencia según la descripción
                    'socio_id' => $socio->id,
                ]); // Generar una incidencia con el texto "Alta"
                $request->merge(['baja' => false]); // Asegurarse de que 'baja' sea false
            }
            // Verificar si el campo 'empresa' es true
            if ($request->input('empresa')) {
                // Realizar alguna acción específica si el socio es una empresa
                //$socio->tipo_empresa = 'empresa'; // Registrar el tipo de empresa
                $request->merge(['empresa' => true]); // Asegurarse de que 'empresa' sea true
            } else {
                //$socio->tipo_empresa = 'particular'; // Registrar el tipo de particular
                $request->merge(['empresa' => false]); // Asegurarse de que 'empresa' sea false
            }
            // Verificar si el campo 'domiciliacion' es true
            if ($request->input('domiciliacion')) {
                // Realizar alguna acción específica si el socio tiene domiciliación
                //$socio->tipo_domiciliacion = 'domiciliacion'; // Registrar el tipo de domiciliación
                $request->merge(['domiciliacion' => true]); // Asegurarse de que 'domiciliacion' sea true
            } else {
                //$socio->tipo_domiciliacion = 'no_domiciliacion'; // Registrar el tipo de no domiciliación
                $request->merge(['domiciliacion' => false]); // Asegurarse de que 'domiciliacion' sea false
            }            
            // Validar los datos de entrada
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:20|unique:socios,dni,' . $socio->id,
                'empresa' => 'required|boolean',
                'baja' => 'required|boolean',
                'domiciliacion' => 'required|boolean',
                // Agrega las demás reglas aquí...
            ]);
            $socio->fill($request->all());
            // Verificar si el DNI ha cambiado y es único
            if ($socio->isDirty('dni')) {
                $socio->dni = $request->input('dni');
                $socio->save();
            }
            $socio->update($request->all());
            // Si el socio se actualiza correctamente, redirigir a la vista de edición
            // y mostrar un mensaje de éxito
            // variable de sesión
            session()->flash('swal', [
                'title' => 'Socio actualizado correctamente',
                'text' => 'El socio se ha actualizado correctamente. ' . ($request->input('empresa') ? 'Sí' : 'No') . ($request->input('baja') ? 'Sí' : 'No') . ($request->input('domiciliacion') ? 'Sí' : 'No'),
                'icon' => 'success',
            ]);
            return view('admin.socios.edit', compact('socio'));
            //return redirect()->route('admin.socios.index');
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
     * Remove the specified resource from storage.
     */
    public function destroy(Socio $socio)
    {
        //
        $socio->delete();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Socio eliminado correctamente',
            'text' => 'El socio se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.socios.index');
    }
}
