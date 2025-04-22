<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $categories = Category::all();
        $categories = Category::orderBy('id', 'desc')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:5|max:255',
        ]);
        Category::create($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Categoría creada correctamente',
            'text' => 'La categoría se ha creado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:5|max:255',
        ]);
        $category->update($request->all());
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Categoria actualizada correctamente',
            'text' => 'La categoria se ha actualizado correctamente',
            'icon' => 'success',
        ]);
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        // variable de sesión
        session()->flash('swal', [
            'title' => 'Categoria eliminada correctamente',
            'text' => 'La categoria se ha eliminado correctamente',
            'icon' => 'success',
        ]);
        
        return redirect()->route('admin.categories.index');
    }
}
