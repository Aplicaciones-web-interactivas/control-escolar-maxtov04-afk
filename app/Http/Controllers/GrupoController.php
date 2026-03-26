<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Horario;

class GrupoController extends Controller
{
    public function index() {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) === 'admin') {
            $grupos = \App\Models\Grupo::all();
            $horarios = \App\Models\Horario::all();
            return view('grupos.index', compact('grupos', 'horarios'));
        }

        if (strtolower($usuario->rol) === 'profesor') {
            $grupos = \App\Models\Grupo::whereHas('horario', function($query) use ($usuario) {
                $query->where('usuario_id', $usuario->id);
            })->get();
            
            return view('grupos.profesor', compact('grupos'));
        }

        if (strtolower($usuario->rol) === 'estudiante') {
            $grupos = \App\Models\Grupo::all();
            
            $misInscripciones = \App\Models\Inscripcion::where('usuario_id', $usuario->id)
                                ->pluck('grupo_id')
                                ->toArray();
                                
            return view('grupos.estudiante', compact('grupos', 'misInscripciones'));
        }

        return redirect()->route('dashboard');
    }

    public function store(Request $request) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para crear grupos.']);
        }
        
        $request->validate([
            'nombre' => 'required',
            'horario_id' => 'required|exists:horarios,id',
        ], [
            'nombre.required' => 'El nombre del grupo es obligatorio (Ej: Grupo A).',
            'horario_id.required' => 'Debes seleccionar un horario para este grupo.',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.lista')->with('success', 'Grupo creado correctamente.');
    }

    public function editar($id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para editar grupos.']);
        }

        $grupo = Grupo::findOrFail($id);
        $horarios = Horario::with(['materia', 'profesor'])->get();
        
        return view('grupos.edit', compact('grupo', 'horarios'));
    }

    public function actualizar(Request $request, $id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para actualizar grupos.']);
        }

        $request->validate([
            'nombre' => 'required',
            'horario_id' => 'required|exists:horarios,id',
        ], [
            'nombre.required' => 'El nombre del grupo es obligatorio.',
            'horario_id.required' => 'Debes seleccionar un horario para este grupo.',
        ]);

        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());

        return redirect()->route('grupos.lista')->with('success', 'Grupo actualizado correctamente.');
    }

    public function eliminar($id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para eliminar grupos.']);
        }

        $grupo = Grupo::findOrFail($id);

        \App\Models\Calificacion::where('grupo_id', $id)->delete();
        \App\Models\Inscripcion::where('grupo_id', $id)->delete();

        $grupo->delete();

        return redirect()->route('grupos.lista')->with('danger', 'El grupo y sus registros ligados fueron eliminados.');
    }
}