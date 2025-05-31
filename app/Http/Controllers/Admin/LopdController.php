<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lopd;
use Illuminate\Http\Request;

class LopdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.lopd.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.lopd.create');
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
    public function show(Lopd $lopd)
    {
        //
        return view('admin.lopd.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lopd $lopd)
    {
        //
        $lopd = Lopd::findOrFail($lopd->id); // Asegúrate de que estás obteniendo el modelo correcto
        return view('admin.gastos.edit', compact('lopd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lopd $lopd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lopd $lopd)
    {
        //
    }
}
