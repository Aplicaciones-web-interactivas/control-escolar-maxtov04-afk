@extends('layouts.app')

@section('contenido')
<div class="mt-6 max-w-sm mx-auto bg-white dark:bg-gray-800 p-8 border border-gray-300 dark:border-gray-700 rounded shadow-sm transition-colors duration-300">
    <h2 class="text-lg font-bold mb-6 text-center border-b dark:border-gray-700 pb-2 dark:text-white transition-colors">CREA TU CUENTA</h2>

    <form action="{{ route('registro') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold mb-1 uppercase text-gray-600 dark:text-gray-400 transition-colors">Nombre Completo</label>
            <input type="text" name="nombre" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded outline-none dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold mb-1 uppercase text-gray-600 dark:text-gray-400 transition-colors">Clave Institucional</label>
            <input type="text" name="clave_institucional" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded outline-none dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold mb-1 uppercase text-gray-600 dark:text-gray-400 transition-colors">Rol de Usuario</label>
            <select name="rol" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded outline-none bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all">
                <option value="estudiante">Estudiante</option>
                <option value="profesor">Profesor</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold mb-1 uppercase text-gray-600 dark:text-gray-400 transition-colors">Contraseña</label>
            <input type="password" name="password" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded outline-none dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all" required>
        </div>
        <button type="submit" class="w-full bg-gray-800 dark:bg-gray-700 text-white py-2 rounded font-bold hover:bg-black dark:hover:bg-gray-600 mt-2 transition-colors">
            REGISTRARME
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-xs text-gray-500 dark:text-gray-400 underline hover:text-gray-900 dark:hover:text-gray-200 transition-colors">Volver al login</a>
    </div>
</div>
@endsection