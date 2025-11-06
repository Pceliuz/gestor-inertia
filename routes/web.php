<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Estudiantes\EstudiantesController;
use App\Http\Controllers\Notas\NotasController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
|
| Si el usuario está autenticado, se le redirige al panel principal (Welcome).
| Si no, se le envía al formulario de login.
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('welcome');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas (solo para usuarios autenticados)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Página principal post-login (usa el controlador WelcomeController)
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

    // 🔹 Grupo de rutas para estudiantes
    Route::prefix('estudiantes')->name('estudiantes.')->group(function () {
        Route::get('/', [EstudiantesController::class, 'index'])->name('index');
        Route::get('/create', [EstudiantesController::class, 'create'])->name('create');
        Route::post('/', [EstudiantesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EstudiantesController::class, 'edit'])->name('edit');
        Route::put('/{estudiante}', [EstudiantesController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [EstudiantesController::class, 'delete'])->name('delete');
        Route::delete('/{estudiante}', [EstudiantesController::class, 'destroy'])->name('destroy');
    });

    // 🔹 Notas
    Route::get('/notas/index', [NotasController::class, 'index'])->name('notas.index');
    Route::get('/notas/simulacion', [NotasController::class, 'simulacion'])->name('notas.simulacion');
    Route::post('/notas/simulacion', [NotasController::class, 'calcularSimulacion'])->name('notas.simulacion.calcular');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (login, logout)
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Carga del sistema de autenticación predeterminado
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
