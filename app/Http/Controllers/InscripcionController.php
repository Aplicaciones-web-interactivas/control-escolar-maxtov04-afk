<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\User;
use App\Models\Grupo;

class InscripcionController extends Controller
    {
    public function index() {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard');
        }

        $inscripciones = Inscripcion::with(['usuario', 'grupo.horario.materia'])->get();
        $alumnos = User::where('rol', 'estudiante')->get(); 
        $grupos = Grupo::with('horario.materia')->get();

        return view('inscripciones.index', compact('inscripciones', 'alumnos', 'grupos'));
    }

    public function store(Request $request) {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
        ]);

        $existe = Inscripcion::where('grupo_id', $request->grupo_id)
                             ->where('usuario_id', $request->usuario_id)
                             ->first();

        if ($existe) {
            return back()->withErrors(['error' => 'El estudiante ya está inscrito en este grupo.']);
        }

        Inscripcion::create([
            'grupo_id' => $request->grupo_id,
            'usuario_id' => $request->usuario_id
        ]);

        $existeCalificacion = Calificacion::where('grupo_id', $request->grupo_id)
                                          ->where('usuario_id', $request->usuario_id)
                                          ->first();

        if (!$existeCalificacion) {
            Calificacion::create([
                'grupo_id' => $request->grupo_id,
                'usuario_id' => $request->usuario_id,
            ]);
        }

        return back()->with('success', 'Inscripción realizada correctamente.');
    }

    public function editar($id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard');
        }

        $inscripcion = Inscripcion::findOrFail($id);
        $alumnos = User::where('rol', 'estudiante')->get();
        $grupos = Grupo::with('horario.materia')->get();

        return view('inscripciones.edit', compact('inscripcion', 'alumnos', 'grupos'));
    }

    public function actualizar(Request $request, $id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
        ]);

        $inscripcion = Inscripcion::findOrFail($id);

        Calificacion::where('grupo_id', $inscripcion->grupo_id)
                    ->where('usuario_id', $inscripcion->usuario_id)
                    ->update([
                        'grupo_id' => $request->grupo_id,
                        'usuario_id' => $request->usuario_id
                    ]);

        $inscripcion->update([
            'grupo_id' => $request->grupo_id,
            'usuario_id' => $request->usuario_id
        ]);

        return redirect()->route('inscripciones.lista')->with('success', 'Inscripción actualizada correctamente.');
    }

    public function eliminar($id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para eliminar inscripciones.']);
        }

        $inscripcion = Inscripcion::findOrFail($id);
        
        Calificacion::where('grupo_id', $inscripcion->grupo_id)
                    ->where('usuario_id', $inscripcion->usuario_id)
                    ->delete();

        $inscripcion->delete();

        return back()->with('danger', 'Inscripción y registro de calificaciones eliminados.');
    }
}