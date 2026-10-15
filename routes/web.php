<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RolMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Todo lo de aquí dentro exige sesión iniciada (middleware "auth").
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PanelController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Solo el Encargado administra equipos y presta/devuelve.
    Route::middleware(RolMiddleware::class.':encargado')->group(function () {
        Route::resource('equipos', EquipoController::class)->except('show');
        Route::post('equipos/{equipo}/prestar', [EquipoController::class, 'prestar'])->name('equipos.prestar');
        Route::post('equipos/{equipo}/devolver', [EquipoController::class, 'devolver'])->name('equipos.devolver');
    });
});

require __DIR__.'/auth.php';
