<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CuotaController;
use App\Http\Controllers\Admin\TincidenciaController;
use App\Http\Controllers\Admin\IncidenciaController;
use App\Http\Controllers\Admin\TSocioController;
use App\Http\Controllers\Admin\SocioController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

//Route::resource('categories', CategoryController::class)->names('admin.categories');
Route::prefix('admin')->group(function () {
    Route::resource('tincidencias', TincidenciaController::class)
        ->names('admin.tincidencias');

    Route::resource('tsocios', TSocioController::class)
        ->names('admin.tsocios');

    Route::resource('cuotas', CuotaController::class)
        ->names('admin.cuotas');

    Route::resource('incidencias', IncidenciaController::class)
        ->names('admin.incidencias');

    Route::resource('categories', CategoryController::class)
        ->names('admin.categories');

    Route::resource('proveedores', \App\Http\Controllers\Admin\ProveedorController::class)
        ->names('admin.proveedores');

    Route::resource('facturas', \App\Http\Controllers\Admin\FacturaController::class)
        ->names('admin.facturas');

    Route::resource('users', UserController::class)
        ->names('admin.users');
        
    Route::resource('socios', SocioController::class)
        ->names('admin.socios');
});
