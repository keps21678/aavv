<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecibosExport;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');

    Volt::route('register', 'auth.register')
        ->name('register');
    // Rutas para la exportación de recibos
    // Asegúrate de que la ruta esté protegida por autenticación si es necesario
    Route::get('/exportar-recibos', function () {
        return Excel::download(new RecibosExport, 'recibos.xlsx');
    })->name('exportar.recibos');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
