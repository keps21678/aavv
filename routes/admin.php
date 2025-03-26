<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

//Route::resource('categories', CategoryController::class)->names('admin.categories');
Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    //});
    //Route::resource('users', UserController::class)->names('admin.users');
    //Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class)->names('admin.users');
});