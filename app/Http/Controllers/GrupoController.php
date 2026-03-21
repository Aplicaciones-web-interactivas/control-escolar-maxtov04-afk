<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Horario;

class GrupoController extends Controller
{
    public function index() {
        $grupos = Grupo::with(['horario.materia', 'horario.profesor'])->get();
        $horarios = Horario::with(['materia', 'profesor'])->get();
        
        return view('grupos.index', compact('grupos', 'horarios'));
    }

    public function store(Request $request) {
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
        $grupo = Grupo::findOrFail($id);
        $horarios = Horario::with(['materia', 'profesor'])->get();
        
        return view('grupos.edit', compact('grupo', 'horarios'));
    }

    public function actualizar(Request $request, $id) {
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
        $grupo = Grupo::findOrFail($id);

        \App\Models\Calificacion::where('grupo_id', $id)->delete();
        \App\Models\Inscripcion::where('grupo_id', $id)->delete();

        $grupo->delete();

        return redirect()->route('grupos.lista')->with('danger', 'El grupo y sus registros ligados fueron eliminados.');
    }
}