<?php

use App\Http\Controllers\Auth\DashboadController;
use App\Http\Controllers\Auth\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Rota raiz e que foi configurada para mostrar a view login.blade.php
Route::get('/', [LoginController::class, 'index'])->name('login');

// Rota para processar o envio (POST)
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Rota para mostrar a view dashboard.blade.php
Route::get('/dashboard', [DashboadController::class, 'index'])->name('dashboard');

// Rota para mostrar a view users.blade.php
Route::get('/users', [UsersController::class, 'index'])->name('users');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');

// Rota para salvar o novo usuário (POST)
Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
