<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lopd;
use App\Models\Socio;
use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LopdController extends Controller
{
    /**
     * Muestra los detalles de un documento LOPD específico.
     */
    public function show(Lopd $lopd)
    {
        return view('admin.lopd.show', compact('lopd'));
    }
    /**
     * Muestra el listado de documentos LOPD.
     */
    public function index(Request $request)
    {
        $socioId = $request->input('socio_id');
        $lopds = Lopd::with(['socio', 'categoria', 'estado'])
            ->when($socioId, function ($query, $socioId) {
                return $query->where('socio_id', $socioId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.lopd.index', compact('lopds'));
    }

    /**
     * Muestra el formulario para crear un nuevo documento LOPD.
     */
    public function create(Request $request)
    {
        $socios = Socio::all();
        $categorias = Categoria::all();
        $estados = Estado::all();
        $socioId = $request->input('socio_id');

        return view('admin.lopd.create', compact('socios', 'categorias', 'estados', 'socioId'));
    }

    /**
     * Almacena un nuevo documento LOPD en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
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
            $data['archivo'] = $archivo->store('lopd', 'private');
            $data['nombre_archivo'] = $archivo->getClientOriginalName(); // Aquí se guarda nombre y extensión
        }

        Lopd::create($data);

        session()->flash('swal', [
            'title' => 'Documento LOPD creado correctamente',
            'text' => 'El documento se ha creado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.lopd.index');
    }

    /**
     * Muestra el formulario para editar un documento LOPD.
     */
    public function edit(Lopd $lopd)
    {
        $socios = Socio::all();
        $categorias = Categoria::all();
        $estados = Estado::all();

        return view('admin.lopd.edit', compact('lopd', 'socios', 'categorias', 'estados'));
    }

    /**
     * Actualiza un documento LOPD existente en la base de datos.
     */
    public function update(Request $request, Lopd $lopd)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
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
            $data['archivo'] = $archivo->store('lopd', 'private');
            $data['nombre_archivo'] = $archivo->getClientOriginalName(); // Aquí se guarda nombre y extensión
        }

        $lopd->update($data);

        session()->flash('swal', [
            'title' => 'Documento LOPD actualizado correctamente',
            'text' => 'El documento se ha actualizado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.lopd.index');
    }

    /**
     * Elimina un documento LOPD de la base de datos.
     */
    public function destroy(Lopd $lopd)
    {
        // Eliminar el archivo asociado si existe
        if ($lopd->archivo && Storage::disk('private')->exists($lopd->archivo)) {
            Storage::disk('private')->delete($lopd->archivo);
        }

        $lopd->delete();

        session()->flash('swal', [
            'title' => 'Documento LOPD eliminado correctamente',
            'text' => 'El documento se ha eliminado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.lopd.index');
    }

    /**
     * Descarga un archivo LOPD.
     */
    public function download($file)
    {
        $path = 'lopd/' . $file;
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }
        // Buscar el registro Lopd por el nombre del archivo almacenado
        $lopd = \App\Models\Lopd::where('archivo', $path)->first();
        $nombreDescarga = $lopd && $lopd->nombre_archivo ? $lopd->nombre_archivo : basename($file);

        $fullPath = Storage::disk('private')->path($path);
        return response()->download($fullPath, $nombreDescarga);
    }

    /**
     * Muestra un archivo LOPD en el navegador.
     */
    public function view($file)
    {
        $path = 'lopd/' . $file;
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
