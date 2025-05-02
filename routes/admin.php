<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\RecibosExport;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CuotaController;
use App\Http\Controllers\Admin\EstadoController;
use App\Http\Controllers\Admin\TincidenciaController;
use App\Http\Controllers\Admin\IncidenciaController;
use App\Http\Controllers\Admin\TSocioController;
use App\Http\Controllers\Admin\SocioController;
use App\Http\Controllers\Admin\ReciboController;
use App\Http\Controllers\Admin\FacturaController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\UserController;

//Route::resource('categories', CategoryController::class)->names('admin.categories');
// Definimos estas rutas para "admin" en bootstrap/app.php

Route::prefix('admin')->group(function () {
    Route::resource('estados', EstadoController::class)
        ->names('admin.estados');

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

    Route::resource('proveedores', ProveedorController::class)
        ->names('admin.proveedores');

    Route::resource('facturas', FacturaController::class)
        ->names('admin.facturas');

    Route::resource('users', UserController::class)
        ->names('admin.users');

    Route::resource('socios', SocioController::class)
        ->names('admin.socios');

    Route::resource('recibos', ReciboController::class)
        ->names('admin.recibos');

    Route::get('/generar-remesa', [ReciboController::class, 'generarRemesa'])
        ->name('recibos.generarRemesa');
    Route::get('/generar-remesa10', [ReciboController::class, 'generarRemesa10'])
        ->name('recibos.generarRemesa10');
});
