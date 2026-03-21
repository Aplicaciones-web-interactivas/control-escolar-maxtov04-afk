<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\CalificacionController;

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

// CRUD DE HORARIOS
Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.lista');
Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.guardar');
Route::get('/horarios/{id}/editar', [HorarioController::class, 'editar'])->name('horarios.editar');
Route::put('/horarios/{id}', [HorarioController::class, 'actualizar'])->name('horarios.actualizar');
Route::delete('/horarios/{id}', [HorarioController::class, 'eliminar'])->name('horarios.eliminar');

// CRUD DE GRUPOS
Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.lista');
Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.guardar');
Route::get('/grupos/{id}/editar', [GrupoController::class, 'editar'])->name('grupos.editar');
Route::put('/grupos/{id}', [GrupoController::class, 'actualizar'])->name('grupos.actualizar');
Route::delete('/grupos/{id}', [GrupoController::class, 'eliminar'])->name('grupos.eliminar');

// CRUD DE CALIFICACIONES
Route::get('/calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.lista');
Route::post('/calificaciones', [CalificacionController::class, 'store'])->name('calificaciones.guardar');
Route::get('/calificaciones/{id}/editar', [CalificacionController::class, 'editar'])->name('calificaciones.editar');
Route::put('/calificaciones/{id}', [CalificacionController::class, 'actualizar'])->name('calificaciones.actualizar');
Route::delete('/calificaciones/{id}', [CalificacionController::class, 'eliminar'])->name('calificaciones.eliminar');