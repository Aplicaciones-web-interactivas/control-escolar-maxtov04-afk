<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Inscripcion;

class CalificacionController extends Controller
{
    public function index() {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) === 'admin') {
            $calificaciones = Calificacion::with(['usuario', 'grupo.horario.materia'])->get();
            return view('calificaciones.index', compact('calificaciones'));
        }

        if (strtolower($usuario->rol) === 'profesor') {
            $misGrupos = Grupo::whereHas('horario', function($query) use ($usuario) {
                $query->where('usuario_id', $usuario->id);
            })->with(['horario.materia'])->get();

            $calificaciones = Calificacion::with(['usuario', 'grupo.horario.materia'])
                ->whereIn('grupo_id', $misGrupos->pluck('id'))
                ->get();

            return view('calificaciones.profesor', compact('calificaciones', 'misGrupos'));
        }

        if (strtolower($usuario->rol) === 'estudiante') {
            $misCalificaciones = Calificacion::with(['grupo.horario.materia', 'grupo.horario.profesor'])
                ->where('usuario_id', $usuario->id)
                ->get();

            return view('calificaciones.estudiante', compact('misCalificaciones'));
        }

        return redirect()->route('dashboard');
    }

    public function actualizar(Request $request, $id) {
        if (!in_array(strtolower(auth()->user()->rol), ['admin', 'profesor'])) {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para calificar.']);
        }

        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $calificacion = Calificacion::findOrFail($id);
        $calificacion->update([
            'calificacion' => $request->calificacion
        ]);

        return back()->with('success', 'Calificación actualizada correctamente.');
    }
}