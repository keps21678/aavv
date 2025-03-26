<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role as ModelsRole;
use Livewire\WithPagination;

class UserController extends Controller
{
    use withPagination;

    public string $name = '';
    public string $email = '';

    public string $search = '';
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->search = '';
    }
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener los usuarios segun la busqueda, necesario pasara a la vista
        // de LiveWire
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->with('roles')
            ->paginate(5);

        if ($users->isEmpty()) {
            session()->flash('swal', [
            'title' => 'No se encontraron usuarios',
            'text' => 'No se encontraron usuarios con los criterios de búsqueda proporcionados',
            'icon' => 'info',
            ]);
        }
        // $users = User::orderBy('id', 'desc')->get();
        // Obtener todos los usuarios con sus roles
        // $users = User::with('roles')->orderBy('id', 'asc')->get();

        // Pasar los usuarios a la vista
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Desde la pantalla de registro
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Usuario/a creado/a correctamente',
            'text' => 'Usuario/a se ha creado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // $users = User::with('roles')->orderBy('id', 'desc')->get();
        $roles = ModelsRole::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        // $user::with('roles')->find($user->id)->roles->pluck('name')->toArray();
        //
        //->toJson();

        return view('admin.users.edit', compact('user', 'userRoles', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);
        $user->roles()->sync($request->roles);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Usuario/a modificado/a correctamente',
            'text' => 'Usuario/a se ha modificado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Usuario/a eliminado/a correctamente',
            'text' => 'Usuario/a se ha eliminado/a correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.users.index');
    }
}
