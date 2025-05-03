<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\RecibosExport;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContabilidadController;
use App\Http\Controllers\Admin\CuotaController;
use App\Http\Controllers\Admin\EstadoController;
use App\Http\Controllers\Admin\TincidenciaController;
use App\Http\Controllers\Admin\IncidenciaController;
use App\Http\Controllers\Admin\TSocioController;
use App\Http\Controllers\Admin\SocioController;
use App\Http\Controllers\Admin\ReciboController;
use App\Http\Controllers\Admin\GastoController;
use App\Http\Controllers\Admin\IngresoController;
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

    Route::resource('users', UserController::class)
        ->names('admin.users');

    Route::resource('socios', SocioController::class)
        ->names('admin.socios');

    Route::resource('recibos', ReciboController::class)
        ->names('admin.recibos');

    Route::resource('contabilidad', ContabilidadController::class)
        ->names('admin.contabilidad');

    Route::resource('gastos', GastoController::class)
        ->names('admin.gastos');

    Route::resource('ingresos', IngresoController::class)
        ->names('admin.ingresos');

    Route::get('/generar-remesa', [ReciboController::class, 'generarRemesa'])
        ->name('recibos.generarRemesa');
});
