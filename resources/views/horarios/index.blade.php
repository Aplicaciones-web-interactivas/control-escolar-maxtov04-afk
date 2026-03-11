@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md mb-8 transition-colors duration-300">
        <h2 class="text-xl font-bold mb-4 dark:text-white transition-colors">Programar Nuevo Horario</h2>
        <form action="{{ route('horarios.guardar') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            
            <select name="materia_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>Selecciona una Materia</option>
                @foreach($materias as $materia)
                    <option value="{{ $materia->id }}">{{ $materia->nombre }} ({{ $materia->clave }})</option>
                @endforeach
            </select>

            <select name="usuario_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>Asignar Profesor</option>
                @foreach($profesores as $profesor)
                    <option value="{{ $profesor->id }}">{{ $profesor->nombre }}</option>
                @endforeach
            </select>

            <div class="md:col-span-3 flex flex-wrap gap-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded border dark:border-gray-600 items-center transition-colors">
                <span class="text-sm dark:text-gray-300 font-bold mr-2">Días:</span>
                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                    <label class="flex items-center gap-2 cursor-pointer text-sm dark:text-gray-300 hover:text-blue-600 transition-colors">
                        <input type="checkbox" name="dias[]" value="{{ $dia }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-500">
                        {{ $dia }}
                    </label>
                @endforeach
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-sm dark:text-gray-300 font-bold">De:</span>
                <input type="time" name="hora_inicio" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-sm dark:text-gray-300 font-bold">A:</span>
                <input type="time" name="hora_fin" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors self-end h-10.5">Guardar Horario</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-hidden transition-colors duration-300">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-200 transition-colors">
                <tr>
                    <th class="p-3">Materia</th>
                    <th class="p-3">Profesor</th>
                    <th class="p-3">Días</th>
                    <th class="p-3">Horario</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                <tr class="border-t dark:border-gray-700 transition-colors">
                    <td class="p-3 dark:text-gray-300 font-bold">{{ $horario->materia->nombre }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $horario->profesor->nombre }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $horario->dias }}</td>
                    <td class="p-3 dark:text-gray-300">{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('horarios.editar', $horario->id) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:text-blue-800 dark:hover:text-blue-300 transition-colors">Editar</a>
                        
                        <form action="{{ route('horarios.eliminar', $horario->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 dark:text-red-400 font-bold hover:text-red-800 dark:hover:text-red-300 transition-colors">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection