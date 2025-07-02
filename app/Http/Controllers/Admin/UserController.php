<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{

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
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        // Obtener los usuarios segun la busqueda, necesario pasara a la vista
        // de LiveWire
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->with('roles')
            ->get();

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
        // Verificar si el usuario tiene el rol de admin
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.users.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Mostrar el formulario de creación de usuario
        $roles = \Spatie\Permission\Models\Role::all(); // O el modelo que uses para roles
        $userRoles = []; // Para creación, normalmente vacío

        return view('admin.users.create', compact('roles', 'userRoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.users.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        try {
            // Validación
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]);

            $validated['password'] = Hash::make($validated['password']);

            event(new Registered(($user = User::create($validated))));

            $user->roles()->sync($request->roles);

            $user->fill($validated);

            $user->language = 'es_ES'; // Establecer el idioma por defecto
            $user->appearance = 'system'; // Establecer la apariencia por defecto

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            session()->flash('swal', [
                'title' => __('User account correctly created'),
                'text' => __('The user account correctly created.'),
                'icon' => 'success',
            ]);
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            // Manejo de error
            session()->flash('swal', [
                'title' => __('Error creating user account'),
                'text' => $e->getMessage(),
                'icon' => 'error',
            ]);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.users.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.users.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole(['admin'])) {
            return redirect()->route('admin.users.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
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
