<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Tarea;
use App\Models\Inscripcion;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    public function misGrupos()
    {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        $grupos = Grupo::whereHas('horario', function ($query) use ($usuario) {
            $query->where('usuario_id', $usuario->id);
        })->with('horario.materia')->get();

        return view('tareas.misGrupos', compact('grupos'));
    }

    public function administrar(Grupo $grupo)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        $tareas = $grupo->tareas()->orderBy('created_at', 'desc')->get();

        return view('tareas.administrarGrupo', compact('grupo', 'tareas'));
    }

    public function store(Request $request, Grupo $grupo)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_entrega' => 'required|date',
            'calificacion' => 'required|integer|min:1',
            'material_apoyo' => 'nullable|file|max:5120',
        ]);

        $rutaArchivo = null;
        if ($request->hasFile('material_apoyo')) {
            $rutaArchivo = $request->file('material_apoyo')->store('materiales', 'public');
        }

        $grupo->tareas()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
            'calificacion' => $request->calificacion,
            'material_apoyo' => $rutaArchivo,
        ]);

        return back()->with('exito', 'Tarea asignada correctamente.');
    }

    public function editar(Tarea $tarea)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        return view('tareas.editTarea', compact('tarea'));
    }

    public function actualizar(Request $request, Tarea $tarea)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_entrega' => 'required|date',
            'calificacion' => 'required|integer|min:1|max:100',
            'material_apoyo' => 'nullable|file|max:5120',
        ], [
            'calificacion.max' => 'La calificación no puede ser mayor a 100 puntos.',
            'calificacion.min' => 'La calificación debe ser al menos de 1 punto.',
            'calificacion.required' => 'Debes asignar un valor a la tarea.',
            'titulo.required' => 'El título es obligatorio.'
        ]);

        $datos = $request->only(['titulo', 'descripcion', 'fecha_entrega', 'calificacion']);

        if ($request->hasFile('material_apoyo')) {
            if ($tarea->material_apoyo) {
                Storage::disk('public')->delete($tarea->material_apoyo);
            }
            $datos['material_apoyo'] = $request->file('material_apoyo')->store('materiales', 'public');
        }

        $tarea->update($datos);

        return redirect()->route('profesor.administrar', $tarea->grupo_id)->with('exito', 'Tarea actualizada correctamente.');
    }

    public function eliminar(Tarea $tarea)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        $grupo_id = $tarea->grupo_id;

        if ($tarea->material_apoyo) {
            Storage::disk('public')->delete($tarea->material_apoyo);
        }
        
        $tarea->delete();

        return redirect()->route('profesor.administrar', $grupo_id)->with('exito', 'Tarea eliminada correctamente.');
    }

    public function misGruposEstudiante()
    {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) !== 'estudiante') {
            return redirect()->route('dashboard');
        }

        $inscripciones = Inscripcion::where('usuario_id', $usuario->id)
            ->with('grupo.horario.materia', 'grupo.horario.usuario')
            ->get();

        return view('tareas.misGruposEstudiante', compact('inscripciones'));
    }

    public function tareasGrupo(Grupo $grupo)
    {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) !== 'estudiante') {
            return redirect()->route('dashboard');
        }

        $tareas = $grupo->tareas()->orderBy('fecha_entrega', 'asc')->get();
        
        $entregas = Entrega::where('usuario_id', $usuario->id)
            ->whereIn('tarea_id', $tareas->pluck('id'))
            ->get()
            ->keyBy('tarea_id');

        return view('tareas.tareasGrupo', compact('grupo', 'tareas', 'entregas'));
    }

    public function entregarTarea(Request $request, Tarea $tarea)
    {
        $usuario = auth()->user();

        if (strtolower($usuario->rol) !== 'estudiante') {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'archivo_pdf' => 'required|mimes:pdf|max:5120',
        ], [
            'archivo_pdf.mimes' => 'El archivo debe ser obligatoriamente un PDF.',
        ]);

        $entregaExistente = Entrega::where('tarea_id', $tarea->id)
                                   ->where('usuario_id', $usuario->id)
                                   ->first();

        if ($entregaExistente && $entregaExistente->calificacion !== null) {
            return back()->withErrors(['No puedes modificar una tarea que ya ha sido calificada.']);
        }

        $rutaPdf = $request->file('archivo_pdf')->store('entregas', 'public');

        if ($entregaExistente) {
            if ($entregaExistente->archivo_pdf) {
                Storage::disk('public')->delete($entregaExistente->archivo_pdf);
            }
            
            $entregaExistente->update([
                'archivo_pdf' => $rutaPdf,
            ]);
            
            $mensaje = 'Tu entrega ha sido actualizada correctamente.';
        } else {
            Entrega::create([
                'tarea_id' => $tarea->id,
                'usuario_id' => $usuario->id,
                'archivo_pdf' => $rutaPdf,
            ]);
            
            $mensaje = 'Tarea entregada correctamente.';
        }

        return back()->with('exito', $mensaje);
    }

    public function revisiones(Tarea $tarea)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        // Traemos todas las entregas de esta tarea, junto con los datos del alumno
        $entregas = Entrega::where('tarea_id', $tarea->id)
            ->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tareas.revisionesTarea', compact('tarea', 'entregas'));
    }

    public function calificar(Request $request, Entrega $entrega)
    {
        if (strtolower(auth()->user()->rol) !== 'profesor') {
            return redirect()->route('dashboard');
        }

        // Validamos que la calificación no sea menor a 0 ni mayor al valor total de la tarea
        $request->validate([
            'calificacion' => 'required|integer|min:0|max:' . $entrega->tarea->calificacion,
            'comentarios' => 'nullable|string',
        ]);

        $entrega->update([
            'calificacion' => $request->calificacion,
            'comentarios' => $request->comentarios,
        ]);

        return back()->with('exito', 'Calificación guardada correctamente.');
    }
}