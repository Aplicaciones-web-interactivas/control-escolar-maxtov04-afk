<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\User;

class HorarioController extends Controller
{
    public function index() {
        $horarios = Horario::with(['materia', 'profesor'])->get();
        $materias = Materia::all();
        $profesores = User::where('rol', 'profesor')->get();
        
        return view('horarios.index', compact('horarios', 'materias', 'profesores'));
    }

    public function store(Request $request) {
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
        $horario = Horario::findOrFail($id);
        $materias = Materia::all();
        $profesores = User::where('rol', 'profesor')->get();
        
        return view('horarios.edit', compact('horario', 'materias', 'profesores'));
    }

    public function actualizar(Request $request, $id) {
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
        Horario::findOrFail($id)->delete();
        return redirect()->route('horarios.lista')->with('danger', 'Horario eliminado del sistema.');
    }
}