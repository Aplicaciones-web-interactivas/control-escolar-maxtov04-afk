<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index() {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave_institucional' => 'required|unique:users',
            'password' => 'required|min:4',
            'rol' => 'required'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('usuarios.lista')->with('success', 'Usuario creado correctamente.');
    }

    public function editar($id) {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function actualizar(Request $request, $id) {
        $usuario = User::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave_institucional' => 'required|unique:users,clave_institucional,'.$id,
            'rol' => 'required'
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->clave_institucional = $request->clave_institucional;
        $usuario->rol = $request->rol;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.lista')->with('success', 'Usuario actualizado.');
    }

    public function eliminar($id) {
        $usuario = User::findOrFail($id);
        
        if (auth()->id() == $id) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propia cuenta de administrador.']);
        }

        \App\Models\Inscripcion::where('usuario_id', $id)->delete();
        \App\Models\Calificacion::where('usuario_id', $id)->delete();

        $horarios = \App\Models\Horario::where('usuario_id', $id)->get();

        foreach ($horarios as $horario) {
            $grupos = \App\Models\Grupo::where('horario_id', $horario->id)->get();

            foreach ($grupos as $grupo) {
                \App\Models\Calificacion::where('grupo_id', $grupo->id)->delete();
                \App\Models\Inscripcion::where('grupo_id', $grupo->id)->delete();
                
                $grupo->delete();
            }
            
            $horario->delete();
        }

        $usuario->delete();

        return redirect()->route('usuarios.lista')->with('danger', 'Usuario y todos sus registros ligados eliminados.');
    }
}