<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documentacion;
use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class DocumentacionController extends Controller
{
    /**
     * Muestra los detalles de un documento.
     */
    public function show(Documentacion $documentacion)
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
        return view('admin.documentacion.show', compact('documentacion'));
    }

    /**
     * Muestra el listado de documentos.
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
        $categoriaId = $request->input('categoria_id');
        $documentos = Documentacion::with(['categoria', 'estado'])
            ->when($categoriaId, function ($query, $categoriaId) {
                return $query->where('categoria_id', $categoriaId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.documentacion.index', compact('documentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo documento.
     */
    public function create()
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.documentacion.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }

        $categorias = Categoria::all();
        $estados = Estado::all();

        return view('admin.documentacion.create', compact('categorias', 'estados'));
    }

    /**
     * Almacena un nuevo documento en la base de datos.
     */
    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.documentacion.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }

        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'required|string|max:255',
            'fecha_firma' => 'nullable|date',
            'archivo' => 'nullable|file|max:2048',
            'nombre_archivo' => 'nullable|string|max:255',
            'estado_id' => 'required|exists:estados,id',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $data = $request->all();

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $data['archivo'] = $archivo->store('documentacion', 'private');
            $data['nombre_archivo'] = $archivo->getClientOriginalName();
        }

        Documentacion::create($data);

        session()->flash('swal', [
            'title' => 'Documento creado correctamente',
            'text' => 'El documento se ha creado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.documentacion.index');
    }

    /**
     * Muestra el formulario para editar un documento.
     */
    public function edit(Documentacion $documentacion)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.documentacion.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        $categorias = Categoria::all();
        $estados = Estado::all();

        return view('admin.documentacion.edit', compact('documentacion', 'categorias', 'estados'));
    }

    /**
     * Actualiza un documento existente en la base de datos.
     */
    public function update(Request $request, Documentacion $documentacion)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            return redirect()->route('admin.documentacion.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'required|string|max:255',
            'fecha_firma' => 'nullable|date',
            'archivo' => 'nullable|file|max:2048',
            'nombre_archivo' => 'nullable|string|max:255',
            'estado_id' => 'required|exists:estados,id',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $data = $request->all();

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $data['archivo'] = $archivo->store('documentacion', 'private');
            $data['nombre_archivo'] = $archivo->getClientOriginalName();
        }

        $documentacion->update($data);

        session()->flash('swal', [
            'title' => 'Documento actualizado correctamente',
            'text' => 'El documento se ha actualizado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.documentacion.index');
    }

    /**
     * Elimina un documento de la base de datos.
     */
    public function destroy(Documentacion $documentacion)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.documentacion.index')
                ->with('swal', [
                    'title' => __('Access Denied'),
                    'text' => __('You are not authorized to access this page.'),
                    'icon' => 'error',
                ]);
        }
        // Verificar si el documento tiene un archivo asociado y eliminarlo
        if ($documentacion->archivo && Storage::disk('private')->exists($documentacion->archivo)) {
            Storage::disk('private')->delete($documentacion->archivo);
        }

        $documentacion->delete();

        session()->flash('swal', [
            'title' => 'Documento eliminado correctamente',
            'text' => 'El documento se ha eliminado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.documentacion.index');
    }

    /**
     * Descarga un archivo.
     */
    public function download($file)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor', 'viewer'])) {
            return redirect()->route('admin.documentacion.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Verificar si el archivo existe en el almacenamiento privado
        $path = 'documentacion/' . $file;
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }
        // Buscar el registro Documentacion por el nombre del archivo almacenado
        $documento = \App\Models\Documentacion::where('archivo', $path)->first();
        $nombreDescarga = $documento && $documento->nombre_archivo ? $documento->nombre_archivo : basename($file);

        $fullPath = Storage::disk('private')->path($path);
        return response()->download($fullPath, $nombreDescarga);
    }

    /**
     * Muestra un archivo en el navegador.
     */
    public function view($file)
    {
        // Verificar si el usuario tiene el rol de admin
        // Si no tiene el rol, redirigir a la lista de usuarios con un mensaje de error
        if (!Auth::user()->hasAnyRole(['admin', 'editor', 'viewer'])) {
            return redirect()->route('admin.documentacion.index')
            ->with('swal', [
                'title' => __('Access Denied'),
                'text' => __('You are not authorized to access this page.'),
                'icon' => 'error',
            ]);
        }
        // Verificar si el archivo existe en el almacenamiento privado
        $path = 'documentacion/' . $file;
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }
        $fullPath = Storage::disk('private')->path($path);
        $mime = File::mimeType($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($file) . '"'
        ]);
    }
}
