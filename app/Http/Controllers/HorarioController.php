<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\User;

class HorarioController extends Controller
{
    public function index() {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) === 'admin') {
            $horarios = Horario::with(['materia', 'profesor'])->get();
            $materias = Materia::all();
            $profesores = User::where('rol', 'profesor')->get();
            
            return view('horarios.index', compact('horarios', 'materias', 'profesores'));
        }

        if (strtolower($usuario->rol) === 'estudiante') {
            $misInscripciones = \App\Models\Inscripcion::where('usuario_id', $usuario->id)->pluck('grupo_id');
            
            $misGrupos = \App\Models\Grupo::with(['horario.materia', 'horario.profesor'])
                                          ->whereIn('id', $misInscripciones)
                                          ->get();

            return view('horarios.estudiante', compact('misGrupos'));
        }

        return redirect()->route('dashboard');
    }

    public function store(Request $request) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para crear horarios.']);
        }

        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'usuario_id' => 'required|exists:users,id',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dias' => 'required|array',
        ], [
            'materia_id.required' => 'Debes seleccionar una materia.',
            'usuario_id.required' => 'Debes asignar un profesor.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'dias.required' => 'Debes seleccionar al menos un día para este horario.',
        ]);

        $datos = $request->all();
        $datos['dias'] = implode(', ', $request->dias);

        Horario::create($datos);

        return redirect()->route('horarios.lista')->with('success', 'Horario creado correctamente.');
    }

    public function editar($id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para editar horarios.']);
        }

        $horario = Horario::findOrFail($id);
        $materias = Materia::all();
        $profesores = User::where('rol', 'profesor')->get();
        
        return view('horarios.edit', compact('horario', 'materias', 'profesores'));
    }

    public function actualizar(Request $request, $id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para actualizar horarios.']);
        }

        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'usuario_id' => 'required|exists:users,id',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dias' => 'required|array',
        ], [
            'materia_id.required' => 'Debes seleccionar una materia.',
            'usuario_id.required' => 'Debes asignar un profesor.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'dias.required' => 'Debes seleccionar al menos un día para este horario.',
        ]);

        $horario = Horario::findOrFail($id);
        
        $datos = $request->all();
        $datos['dias'] = implode(', ', $request->dias);

        $horario->update($datos);

        return redirect()->route('horarios.lista')->with('success', 'Horario actualizado correctamente.');
    }

    public function eliminar($id) {
        if (strtolower(auth()->user()->rol) !== 'admin') {
            return redirect()->route('dashboard')->withErrors(['error' => 'No tienes permiso para eliminar horarios.']);
        }

        $horario = Horario::findOrFail($id);
        
        $grupos = \App\Models\Grupo::where('horario_id', $id)->get();
        foreach ($grupos as $grupo) {
            \App\Models\Calificacion::where('grupo_id', $grupo->id)->delete();
            \App\Models\Inscripcion::where('grupo_id', $grupo->id)->delete();
            $grupo->delete();
        }

        $horario->delete();

        return redirect()->route('horarios.lista')->with('danger', 'El horario y sus grupos ligados fueron eliminados.');
    }
}