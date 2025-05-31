<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Muestra el listado de categorías.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('id', 'desc')->get();
        return view('admin.categorias.index', ['categorias' => $categorias]);
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'descripcion' => 'required|string|min:5|max:255',
            'color' => 'nullable|string|max:20',
        ]);
        Categoria::create($request->only(['nombre', 'descripcion', 'color']));
        session()->flash('swal', [
            'title' => 'Categoría creada correctamente',
            'text' => 'La categoría se ha creado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.categorias.index');
    }

    /**
     * Muestra una categoría específica.
     */
    public function show(Categoria $categoria)
    {
        return view('admin.categorias.show', ['categoria' => $categoria]);
    }

    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', ['categoria' => $categoria]);
    }

    /**
     * Actualiza una categoría existente en la base de datos.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'descripcion' => 'required|string|min:5|max:255',
            'color' => 'nullable|string|max:20',
        ]);
        $categoria->update($request->only(['nombre', 'descripcion', 'color']));
        session()->flash('swal', [
            'title' => 'Categoría actualizada correctamente',
            'text' => 'La categoría se ha actualizado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.categorias.index');
    }

    /**
     * Elimina una categoría de la base de datos.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        session()->flash('swal', [
            'title' => 'Categoría eliminada correctamente',
            'text' => 'La categoría se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.categorias.index');
    }
}
