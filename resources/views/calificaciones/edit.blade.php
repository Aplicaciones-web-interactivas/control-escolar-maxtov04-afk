@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md transition-colors duration-300">
        <h2 class="text-xl font-bold mb-6 dark:text-white transition-colors">Editar Calificación</h2>
        
        <form action="{{ route('calificaciones.actualizar', $calificacion->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Grupo:</label>
                <select name="grupo_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    <option value="" disabled>Selecciona un Grupo</option>
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}" {{ $calificacion->grupo_id == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Alumno:</label>
                <select name="usuario_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    <option value="" disabled>Selecciona un Alumno</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" {{ $calificacion->usuario_id == $alumno->id ? 'selected' : '' }}>
                            {{ $alumno->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Calificación:</label>
                <input type="number" step="0.01" name="calificacion" value="{{ $calificacion->calificacion }}" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div class="flex justify-between items-center mt-6 pt-4 border-t dark:border-gray-700 transition-colors">
                <a href="{{ route('calificaciones.lista') }}" class="text-gray-600 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-200 transition-colors">Cancelar</a>
                <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                    Actualizar Calificación
                </button>
            </div>
        </form>
    </div>
</div> 
@endsection