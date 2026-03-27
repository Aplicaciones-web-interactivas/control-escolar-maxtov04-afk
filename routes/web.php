<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Http;

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

// CRUD DE INSCRIPCIONES
Route::get('/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.lista');
Route::post('/inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.guardar');
Route::get('/inscripciones/{id}/editar', [InscripcionController::class, 'editar'])->name('inscripciones.editar');
Route::put('/inscripciones/{id}', [InscripcionController::class, 'actualizar'])->name('inscripciones.actualizar');
Route::delete('/inscripciones/{id}', [InscripcionController::class, 'eliminar'])->name('inscripciones.eliminar');

// CRUD DE USUARIOS
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.lista');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.guardar');
Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar'])->name('usuarios.editar');
Route::put('/usuarios/{id}', [UsuarioController::class, 'actualizar'])->name('usuarios.actualizar');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminar'])->name('usuarios.eliminar');

// RUTAS DE TAREAS Y ENTREGAS
Route::get('/profesor/mis-grupos', [TareaController::class, 'misGrupos'])->name('profesor.misGrupos');
Route::get('/profesor/grupo/{grupo}/administrar', [TareaController::class, 'administrar'])->name('profesor.administrar');
Route::post('/profesor/grupo/{grupo}/tareas', [TareaController::class, 'store'])->name('profesor.tareas.store');
Route::get('/profesor/tareas/{tarea}/editar', [TareaController::class, 'editar'])->name('profesor.tareas.editar');
Route::put('/profesor/tareas/{tarea}', [TareaController::class, 'actualizar'])->name('profesor.tareas.actualizar');
Route::delete('/profesor/tareas/{tarea}', [TareaController::class, 'eliminar'])->name('profesor.tareas.eliminar');

Route::get('/estudiante/mis-grupos', [TareaController::class, 'misGruposEstudiante'])->name('estudiante.misGrupos');
Route::get('/estudiante/grupo/{grupo}/tareas', [TareaController::class, 'tareasGrupo'])->name('estudiante.tareas');
Route::post('/estudiante/tareas/{tarea}/entregar', [TareaController::class, 'entregarTarea'])->name('estudiante.tareas.entregar');

// REVISIÓN PROFESOR DE ENTREGAS
Route::get('/profesor/tareas/{tarea}/revisiones', [TareaController::class, 'revisiones'])->name('profesor.tareas.revisiones');
Route::put('/profesor/entregas/{entrega}/calificar', [TareaController::class, 'calificar'])->name('profesor.entregas.calificar');

// CHUCK NORRIS
Route::get('/', function () {return redirect()->route('login');});

Route::get('/inicio', function () {
    $totalMaterias = \App\Models\Materia::count();
    $totalUsuarios = \App\Models\User::count();

    $chisteChuckNorris = null;

    if (Auth::user()->rol === 'profesor') {
        try {
            $respuestaChuck = Http::withoutVerifying()->get('https://api.chucknorris.io/jokes/random');

            if ($respuestaChuck->successful()) {
                $chisteIngles = $respuestaChuck->json()['value'];

            $respuestaTraduccion = Http::withoutVerifying()->get('https://api.mymemory.translated.net/get', [
                'q' => $chisteIngles,
                'langpair' => 'en|es'
            ]);

                if ($respuestaTraduccion->successful()) {
                    $chisteChuckNorris = $respuestaTraduccion->json()['responseData']['translatedText'];
                }
            }
        } catch (\Exception $e) {
            $chisteChuckNorris = "Chuck Norris ya murió";
        }
    }

    return view('dashboard', compact('totalMaterias', 'totalUsuarios', 'chisteChuckNorris'));})->name('dashboard')->middleware('auth');