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
            ->paginate(10);

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
        $socio->email = 'Escriba el email del usuario';
        return view('admin.socios.create', compact('socio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'nsocio' => 'required|integer',
                'empresa' => 'required|boolean',
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:255',
                'movil' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'calle' => 'nullable|string|max:255',
                'portal' => 'nullable|string|max:255',
                'piso' => 'nullable|string|max:255',
                'letra' => 'nullable|string|max:255',
                'codigo_postal' => 'nullable|string|max:255',
                'poblacion' => 'nullable|string|max:255',
                'provincia' => 'nullable|string|max:255',
                'persona_contacto' => 'nullable|string|max:255',
                // Otros campos...
                'domiciliacion' => 'required|boolean',
                'iban' => 'nullable|string|max:255',
                'tiposocio_id' => 'required|integer',
                'cuota_id' => 'required|integer',
            ]);
            Socio::create($request->all());
            // variable de sesión
            session()->flash('swal', [
                'title' => 'Socio creado correctamente',
                'text' => 'El socio se ha creado correctamente',
                'icon' => 'success',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, revise los campos e intente nuevamente.',
                'icon' => 'error',
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        return redirect()->route('admin.socios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Socio $socio)
    {
        //
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
        //
        try {
            $request->validate([
                'nsocio' => 'required|integer',
                'empresa' => 'required|boolean',
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:255',
                'movil' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'calle' => 'nullable|string|max:255',
                'portal' => 'nullable|string|max:255',
                'piso' => 'nullable|string|max:255',
                'letra' => 'nullable|string|max:255',
                'codigo_postal' => 'nullable|string|max:255',
                'poblacion' => 'nullable|string|max:255',
                'provincia' => 'nullable|string|max:255',
                'persona_contacto' => 'nullable|string|max:255',
                // Otros campos...
                'domiciliacion' => 'required|boolean',
                'iban' => 'nullable|string|max:255',
                'tiposocio_id' => 'required|integer',
                'cuota_id' => 'required|integer',
            ]);
            $socio->update($request->all());
            // variable de sesión
            session()->flash('swal', [
                'title' => 'Socio creado correctamente',
                'text' => 'El socio se ha creado correctamente',
                'icon' => 'success',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('swal', [
                'title' => 'Error de validación',
                'text' => 'Por favor, revise los campos e intente nuevamente.',
                'icon' => 'error',
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        return redirect()->route('admin.socios.index');
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
