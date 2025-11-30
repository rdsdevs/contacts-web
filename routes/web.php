<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Ruta de inicio
Route::get('/', function () {
    if (session('token')) {
        return redirect()->route('contacts.index');
    }
    return redirect()->route('login');
});

// Rutas públicas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas
Route::middleware('auth.session')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas de contactos
    Route::resource('contacts', ContactController::class)->only(['index', 'create', 'store', 'show']);
});

