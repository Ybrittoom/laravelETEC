<?php

use App\Http\Controllers\Auth\DashboadController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

// ─── Rotas públicas ────────────────────────────────────────────────
Route::get('/',       [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Rotas de Registro (públicas — fora do middleware auth)
Route::get('/register',  [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.post');

// ─── Rotas protegidas (exigem login) ───────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/home',      [DashboadController::class, 'home'])->name('home');
    Route::get('/dashboard', [DashboadController::class, 'index'])->name('dashboard');

    // CRUD completo de Usuários
    Route::get('/users',            [UsersController::class, 'index'])->name('users');
    Route::get('/users/create',     [UsersController::class, 'create'])->name('users.create');
    Route::post('/users/store',     [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit',  [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}',       [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}',    [UsersController::class, 'destroy'])->name('users.destroy');

    // Chat (acessível para todos os perfis autenticados)
    Route::get('/chat',  [ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
});