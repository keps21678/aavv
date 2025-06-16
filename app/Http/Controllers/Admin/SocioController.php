<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use App\Models\TSocio;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
        // Obtener los socios segun la busqueda, necesario pasara a la vista
        // de LiveWire
        $socios = Socio::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('apellidos', 'LIKE', '%' . $this->search . '%')
            ->orderBy('nsocio', 'asc')
            ->withCount('incidencias')
            ->get();
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.socios.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        $socio = new Socio();
        $socio->nsocio = Socio::max('nsocio') + 1; // Generar el número de socio automáticamente

        // Obtener los tipos de socios y cuotas
        $tsocios = TSocio::all(); // Asegúrate de que el modelo TSocio existe
        $cuotas = Cuota::where('anyo', '>=', now()->year)->get(); // Obtener cuotas del año actual y futuros

        return view('admin.socios.create', compact('socio', 'tsocios', 'cuotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.socios.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        $validatedData = $request->validate([
            'nsocio' => 'required|integer|unique:socios,nsocio',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => [
                'required',
                'string',
                'max:20',
                'unique:socios,dni',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidDni($value)) {
                        $fail('El DNI proporcionado no es válido.');
                    }
                },
            ],
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
            'persona_contacto' => 'nullable|string|max:255',
            'iban' => [
                'nullable',
                'string',
                'max:34',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidIban($value)) {
                        $fail('El IBAN proporcionado no es válido.');
                    }
                },
            ],
            'titular' => 'nullable|string|max:255',
            'dni_titular' => 'nullable|string|max:20',
            'empresa' => 'boolean',
            'baja' => 'boolean',
            'domiciliacion' => 'boolean',
            'tsocio_id' => 'required|exists:tsocios,id',
            'cuota_id' => 'required|exists:cuotas,id',
            // Agrega aquí cualquier otro campo nuevo...
        ]);

        Socio::create($validatedData);

        session()->flash('swal', [
            'title' => 'Socio creado correctamente',
            'text' => 'El socio se ha creado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.socios.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Socio $socio)
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
        return view('admin.socios.show', compact('socio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Socio $socio)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.socios.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        $tsocios = TSocio::all();
        $cuotas = Cuota::where('anyo', '>=', now()->year - 1)->get(); // Obtener cuotas del año actual y futuros
        $socio->loadCount('incidencias')->loadCount('lopds');
        return view('admin.socios.edit', compact('socio', 'tsocios', 'cuotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Socio $socio)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.socios.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        if (!$request->has('baja')) {
            $request->merge(['baja' => false]);
        }
        if (!$request->has('empresa')) {
            $request->merge(['empresa' => false]);
        }
        if (!$request->has('domiciliacion')) {
            $request->merge(['domiciliacion' => false]);
        }
        try {
            // Verificar si el campo 'baja' es true
            if ($socio->baja !== $request->input('baja')) {
                if ($request->input('baja')) {
                    // Realizar alguna acción específica si el socio está dado de baja                
                    $socio->incidencias()->create([
                        'descripcion' => 'Baja',
                        'fecha_incidencia' => now(),
                        'tincidencia_id' => \App\Models\Tincidencia::where('nombre', 'Baja')->value('id'), // Buscar el ID de la incidencia según la descripción
                        'socio_id' => $socio->id,
                        'estado_id' => \App\Models\Estado::where('nombre', 'Anulado')->value('id'), // Buscar el ID del estado según la descripción
                    ]); // Generar una incidencia con el texto "Baja"
                    $request->merge(['baja' => true]); // Asegurarse de que 'baja' sea true
                } else {
                    $socio->incidencias()->create([
                        'descripcion' => 'Alta, tras una baja',
                        'fecha_incidencia' => now(),
                        'tincidencia_id' => \App\Models\Tincidencia::where('nombre', 'Alta')->value('id'), // Buscar el ID de la incidencia según la descripción
                        'socio_id' => $socio->id,
                        'estado_id' => \App\Models\Estado::where('nombre', 'Recuperado')->value('id'), // Buscar el ID del estado según la descripción
                    ]); // Generar una incidencia con el texto "Alta"
                    $request->merge(['baja' => false]); // Asegurarse de que 'baja' sea false
                }
            }
            // Verificar si el campo 'empresa' es true
            if ($request->input('empresa') !== $socio->empresa) {
                if ($request->input('empresa')) {
                    // Realizar alguna acción específica si el socio es una empresa
                    //$socio->tipo_empresa = 'empresa'; // Registrar el tipo de empresa
                    $request->merge(['empresa' => true]); // Asegurarse de que 'empresa' sea true
                } else {
                    //$socio->tipo_empresa = 'particular'; // Registrar el tipo de particular
                    $request->merge(['empresa' => false]); // Asegurarse de que 'empresa' sea false
                }
            }
            // Verificar si el campo 'domiciliacion' es true
            if ($request->input('domiciliacion') !== $socio->domiciliacion) {
                if ($request->input('domiciliacion')) {
                    // Realizar alguna acción específica si el socio tiene domiciliación
                    $request->merge(['domiciliacion' => true]); // Asegurarse de que 'domiciliacion' sea true
                } else {
                    $request->merge(['domiciliacion' => false]); // Asegurarse de que 'domiciliacion' sea false
                }
            }
            // Validar los datos de entrada
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:20|unique:socios,dni,' . $socio->id,
                'empresa' => 'required|boolean',
                'baja' => 'required|boolean',
                'domiciliacion' => 'required|boolean',
                'tsocio_id' => 'required|exists:tsocios,id',
                'cuota_id' => 'required|exists:cuotas,id',
                // Agrega las demás reglas aquí...
                'dni' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:socios,dni,' . $socio->id, // Permitir el valor actual del DNI
                    function ($attribute, $value, $fail) {
                        if (!$this->isValidDni($value)) {
                            $fail('El DNI proporcionado no es válido.');
                        }
                    },
                    'iban' => [
                        'nullable',
                        'string',
                        'max:34',
                        function ($attribute, $value, $fail) {
                            if (!$this->isValidIban($value)) {
                                $fail('El IBAN proporcionado no es válido.');
                            }
                        },
                    ],
                ],
            ]);
            $socio->fill($request->all());
            // Verificar si el DNI ha cambiado y es único
            if ($socio->isDirty('dni')) {
                $socio->fill(['dni' => $request->input('dni')]);
                $socio->save();
            }
            $socio->update($request->all());
            // Si el socio se actualiza correctamente, redirigir a la vista de edición
            // y mostrar un mensaje de éxito
            // variable de sesión
            session()->flash('swal', [
                'title' => 'Socio actualizado correctamente',
                'text' => 'El socio se ha actualizado correctamente. ',
                'icon' => 'success',
            ]);

            // Obtener los tipos de socios y cuotas
            $tsocios = TSocio::all(); // Asegúrate de que el modelo TSocio existe
            $cuotas = Cuota::where('anyo', '>=', now()->year - 1)->get(); // Obtener cuotas del año actual y futuros
            //return view('admin.socios.edit', compact('socio'));
            return redirect()->route('admin.socios.edit', compact('socio', 'tsocios', 'cuotas'));
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
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.socios.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        //
        $socio->delete();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Socio eliminado correctamente',
            'text' => 'El socio se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.socios.index');
        //return redirect()->route('admin.socios.index');
    }
    /**
     * Validate the IBAN.
     *
     * @param string $iban
     * @return bool
     */
    private function isValidIban(string $iban): bool
    {
        // Elimina espacios y convierte a mayúsculas
        $iban = strtoupper(str_replace(' ', '', $iban));

        // Verifica la longitud mínima y máxima del IBAN
        if (strlen($iban) < 15 || strlen($iban) > 34) {
            return false;
        }

        // Mueve los primeros 4 caracteres al final
        $iban = substr($iban, 4) . substr($iban, 0, 4);

        // Reemplaza las letras por números (A=10, B=11, ..., Z=35)
        $iban = preg_replace_callback('/[A-Z]/', function ($match) {
            return ord($match[0]) - 55;
        }, $iban);

        // Calcula el módulo 97
        $remainder = intval(substr($iban, 0, 1));
        for ($i = 1, $len = strlen($iban); $i < $len; $i++) {
            $remainder = intval($remainder . $iban[$i]) % 97;
        }

        return $remainder === 1;
    }
    /**
     * Validate the DNI.
     *
     * @param string $dni
     * @return bool
     */
    private function isValidDni(string $dni): bool
    {
        // Elimina espacios y convierte a mayúsculas
        $dni = strtoupper(str_replace(' ', '', $dni));

        // Verifica que el formato sea válido (8 números seguidos de una letra)
        if (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
            return false;
        }

        // Extrae los números y la letra
        $numbers = substr($dni, 0, 8);
        $letter = substr($dni, -1);

        // Calcula la letra correcta
        $validLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $correctLetter = $validLetters[$numbers % 23];

        // Compara la letra proporcionada con la calculada
        return $letter === $correctLetter;
    }
}
