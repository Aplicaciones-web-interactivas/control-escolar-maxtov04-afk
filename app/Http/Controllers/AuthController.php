<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistro() {
        return view('auth.registro');
    }

    public function registrar(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'clave_institucional' => 'required|unique:users',
            'rol' => 'required|in:estudiante,profesor,admin',
            'password' => 'required',
        ], [
            'clave_institucional.unique' => 'Esta clave institucional ya está registrada en el sistema.',
            'nombre.required' => 'El nombre completo es obligatorio.',
            'clave_institucional.required' => 'La clave institucional es obligatoria.',
            'password.required' => 'Debes ingresar una contraseña.'
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
            'activo' => true,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', '¡Bienvenido al sistema, ' . $user->nombre . '!');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('clave_institucional', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->route('dashboard')->with('success', '¡Bienvenido de nuevo, ' . Auth::user()->nombre . '!');
        }

        return back()->withErrors(['error' => 'Error. Tus credenciales no son válidas.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }
}