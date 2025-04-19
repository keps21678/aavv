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
            // Asegurarse de que los valores sean booleanos
            $validatedData['empresa'] = filter_var($request->input('empresa', false), FILTER_VALIDATE_BOOLEAN);
            $validatedData['baja'] = filter_var($request->input('baja', false), FILTER_VALIDATE_BOOLEAN);
            $validatedData['domiciliacion'] = filter_var($request->input('domiciliacion', false), FILTER_VALIDATE_BOOLEAN);
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:20|unique:socios,dni,' . $socio->id,
                'empresa' => 'boolean',
                'baja' => 'boolean',
                'domiciliacion' => 'boolean',
                // Agrega las demás reglas aquí...
            ]);

            $socio->update($validatedData);

            session()->flash('swal', [
                'title' => 'Socio actualizado correctamente',
                'text' => 'El socio se ha actualizado correctamente.',
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
