@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md transition-colors duration-300">
        <h2 class="text-xl font-bold mb-6 dark:text-white transition-colors">Editar Horario</h2>
        
        <form action="{{ route('horarios.actualizar', $horario->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Materia:</label>
                <select name="materia_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    <option value="" disabled>Selecciona una Materia</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}" {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                            {{ $materia->nombre }} ({{ $materia->clave }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Profesor:</label>
                <select name="usuario_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    <option value="" disabled>Asignar Profesor</option>
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}" {{ $horario->usuario_id == $profesor->id ? 'selected' : '' }}>
                            {{ $profesor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Días:</label>
                <div class="flex flex-wrap gap-4 p-3 border dark:border-gray-600 rounded dark:bg-gray-700/50 transition-colors">
                    @php
                        // Convertimos el string "Lunes, Miércoles" a un array para compararlo
                        $diasGuardados = explode(', ', $horario->dias);
                    @endphp
                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                        <label class="flex items-center gap-2 cursor-pointer text-sm dark:text-gray-300 hover:text-blue-600 transition-colors">
                            <input type="checkbox" name="dias[]" value="{{ $dia }}" 
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-500"
                                   {{ in_array($dia, $diasGuardados) ? 'checked' : '' }}>
                            {{ $dia }}
                        </label>
                    @endforeach
                </div>
            </div>
            
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Hora de Inicio:</label>
                    <input type="time" name="hora_inicio" value="{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Hora de Fin:</label>
                    <input type="time" name="hora_fin" value="{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6 pt-4 border-t dark:border-gray-700 transition-colors">
                <a href="{{ route('horarios.lista') }}" class="text-gray-600 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-200 transition-colors">Cancelar</a>
                <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                    Actualizar Horario
                </button>
            </div>
        </form>
    </div>
</div> 
@endsection