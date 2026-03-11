<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;

// INICIO Y AUTH
Route::get('/', function () { return view('dashboard'); })->name('dashboard');

Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// CRUD DE MATERIAS
Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
Route::get('/materias/{id}/edit', [MateriaController::class, 'editar'])->name('materias.editar');
Route::put('/materias/{id}', [MateriaController::class, 'actualizar'])->name('materias.actualizar');
Route::delete('/materias/{id}', [MateriaController::class, 'eliminar'])->name('materias.eliminar');