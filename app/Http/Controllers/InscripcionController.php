<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Grupo;
use App\Models\User;

class InscripcionController extends Controller
{
    public function index() {
        $inscripciones = Inscripcion::with(['grupo.horario.materia', 'alumno'])->get();
        $grupos = Grupo::with(['horario.materia', 'horario.profesor'])->get();
        $alumnos = User::whereIn('rol', ['alumno', 'estudiante', 'Estudiante'])->get();
        
        return view('inscripciones.index', compact('inscripciones', 'grupos', 'alumnos'));
    }

    public function store(Request $request) {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
        ], [
            'grupo_id.required' => 'Debes seleccionar un grupo.',
            'usuario_id.required' => 'Debes seleccionar un alumno para inscribir.',
        ]);

        $existe = Inscripcion::where('grupo_id', $request->grupo_id)
                             ->where('usuario_id', $request->usuario_id)
                             ->first();

        if ($existe) {
            return back()->withErrors(['error' => 'El alumno ya está inscrito en este grupo.']);
        }

        Inscripcion::create($request->all());

        return redirect()->route('inscripciones.lista')->with('success', 'Alumno inscrito correctamente.');
    }

    public function editar($id) {
        $inscripcion = Inscripcion::findOrFail($id);
        $grupos = Grupo::with(['horario.materia', 'horario.profesor'])->get();
        $alumnos = User::whereIn('rol', ['alumno', 'estudiante', 'Estudiante'])->get();
        
        return view('inscripciones.edit', compact('inscripcion', 'grupos', 'alumnos'));
    }

    public function actualizar(Request $request, $id) {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
        ], [
            'grupo_id.required' => 'Debes seleccionar un grupo.',
            'usuario_id.required' => 'Debes seleccionar un alumno.',
        ]);

        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->update($request->all());

        return redirect()->route('inscripciones.lista')->with('success', 'Inscripción actualizada correctamente.');
    }

    public function eliminar($id) {
        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->delete();
        
        return redirect()->route('inscripciones.lista')->with('danger', 'Inscripción eliminada del sistema.');
    }
}