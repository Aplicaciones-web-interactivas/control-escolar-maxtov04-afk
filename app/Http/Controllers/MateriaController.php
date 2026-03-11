<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    public function index() {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'clave' => 'required|unique:materias'
        ], [
            'clave.unique' => 'Ya existe una materia registrada con esta clave.',
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'clave.required' => 'La clave de la materia es obligatoria.'
        ]);
        
        Materia::create($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
    }

    public function editar($id) {
        $materia = Materia::findOrFail($id);
        return view('materias.edit', compact('materia'));
    }

    public function actualizar(Request $request, $id) {
        $request->validate([
            'nombre' => 'required',
            'clave' => 'required|unique:materias,clave,' . $id 
        ], [
            'clave.unique' => 'Esta clave ya está siendo usada por otra materia.',
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'clave.required' => 'La clave de la materia es obligatoria.'
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($request->all());

        return redirect()->route('materias.index')->with('success', 'La materia se actualizó correctamente.');
    }

    public function eliminar($id) {
        Materia::findOrFail($id)->delete();

        return redirect()->route('materias.index')->with('danger', 'Materia eliminada del sistema.');
    }
}