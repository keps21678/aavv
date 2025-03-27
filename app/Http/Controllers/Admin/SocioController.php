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
        return view('admin.socios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Socio $socio)
    {
        //
    }
}
