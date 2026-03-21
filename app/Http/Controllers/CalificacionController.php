<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\User;

class CalificacionController extends Controller
{
    public function index() {
        $calificaciones = Calificacion::with(['grupo', 'alumno'])->get();
        $grupos = Grupo::all();
        $alumnos = User::where('rol', 'alumno')->get();
        
        return view('calificaciones.index', compact('calificaciones', 'grupos', 'alumnos'));
    }

    public function store(Request $request) {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
            'calificacion' => 'required|numeric|min:0|max:100',
        ], [
            'grupo_id.required' => 'Debes seleccionar un grupo.',
            'usuario_id.required' => 'Debes seleccionar un alumno.',
            'calificacion.required' => 'La calificación es obligatoria.',
            'calificacion.numeric' => 'La calificación debe ser un número.',
        ]);

        Calificacion::create($request->all());

        return redirect()->route('calificaciones.lista')->with('success', 'Calificación registrada correctamente.');
    }

    public function editar($id) {
        $calificacion = Calificacion::findOrFail($id);
        $grupos = Grupo::all();
        $alumnos = User::where('rol', 'alumno')->get();
        
        return view('calificaciones.edit', compact('calificacion', 'grupos', 'alumnos'));
    }

    public function actualizar(Request $request, $id) {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
            'calificacion' => 'required|numeric|min:0|max:100',
        ], [
            'grupo_id.required' => 'Debes seleccionar un grupo.',
            'usuario_id.required' => 'Debes seleccionar un alumno.',
            'calificacion.required' => 'La calificación es obligatoria.',
            'calificacion.numeric' => 'La calificación debe ser un número.',
        ]);

        $calificacion = Calificacion::findOrFail($id);
        $calificacion->update($request->all());

        return redirect()->route('calificaciones.lista')->with('success', 'Calificación actualizada correctamente.');
    }

    public function eliminar($id) {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();
        
        return redirect()->route('calificaciones.lista')->with('danger', 'Calificación eliminada del sistema.');
    }
}