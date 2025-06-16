<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\RecibosExport;

use App\Http\Controllers\Admin\LopdController;
use App\Http\Controllers\Admin\DocumentacionController;
use App\Http\Controllers\Admin\CategoriaController;
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
    Route::resource('lopd', LopdController::class)
        ->names('admin.lopd');

    Route::get('lopd/archivo/{file}', [LopdController::class, 'download'])->name('lopd.download');
    Route::get('lopd/ver/{file}', [LopdController::class, 'view'])->name('lopd.view');


    Route::resource('documentacion', DocumentacionController::class)
        ->names('admin.documentacion');
    Route::get('documentacion/view/{file}', [DocumentacionController::class, 'view'])
        ->name('documentacion.view');
    Route::get('documentacion/download/{file}', [DocumentacionController::class, 'download'])
        ->name('documentacion.download');

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

    Route::resource('categorias', CategoriaController::class)
        ->names('admin.categorias');

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
        ->name('admin.recibos.generarRemesa');
});
