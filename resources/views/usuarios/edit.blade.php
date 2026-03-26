@extends('layouts.app')

@section('contenido')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md transition-colors duration-300">
        <h2 class="text-xl font-bold mb-6 dark:text-white transition-colors">Editar Usuario</h2>
        
        <form action="{{ route('usuarios.actualizar', $usuario->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nombre Completo</label>
                <input type="text" name="nombre" value="{{ $usuario->nombre }}" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Clave / Matrícula</label>
                <input type="text" name="clave_institucional" value="{{ $usuario->clave_institucional }}" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Rol</label>
                <select name="rol" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="profesor" {{ $usuario->rol == 'profesor' ? 'selected' : '' }}>Profesor</option>
                    <option value="estudiante" {{ $usuario->rol == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nueva Contraseña</label>
                <input type="password" name="password" placeholder="Deja en blanco para no cambiarla" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Solo llena este campo si deseas cambiar la contraseña actual del usuario.</p>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('usuarios.lista') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors font-bold">Actualizar Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection