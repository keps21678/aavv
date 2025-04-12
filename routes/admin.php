<?php

use App\Http\Controllers\Admin\Tipo_IncidenciaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TincidenciaController;
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

    Route::resource('categories', CategoryController::class)
        ->names('admin.categories');
    //});
    //Route::resource('users', UserController::class)->names('admin.users');
    //Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class)
        ->names('admin.users');
    Route::resource('socios', SocioController::class)
        ->names('admin.socios');
});
