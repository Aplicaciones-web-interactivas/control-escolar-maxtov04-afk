@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md mb-8 transition-colors duration-300">
        <h2 class="text-xl font-bold mb-4 dark:text-white transition-colors">Crear Nuevo Grupo</h2>
        <form action="{{ route('grupos.guardar') }}" method="POST" class="flex flex-col md:flex-row gap-4">
            @csrf
            
            <input type="text" name="nombre" placeholder="Nombre (Ej: Grupo I-12)" class="border dark:border-gray-600 p-2 rounded w-full md:w-1/3 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            
            <select name="horario_id" class="border dark:border-gray-600 p-2 rounded w-full md:w-2/3 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>Selecciona un Horario</option>
                @foreach($horarios as $horario)
                    <option value="{{ $horario->id }}">
                        {{ $horario->materia->nombre }} - {{ $horario->profesor->nombre }} ({{ $horario->dias }}) de {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors font-bold w-full md:w-auto">Guardar</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-hidden transition-colors duration-300">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-200 transition-colors">
                <tr>
                    <th class="p-3">Grupo</th>
                    <th class="p-3">Materia</th>
                    <th class="p-3">Profesor</th>
                    <th class="p-3">Horario</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grupos as $grupo)
                <tr class="border-t dark:border-gray-700 transition-colors">
                    <td class="p-3 dark:text-gray-300 font-black">{{ $grupo->nombre }}</td>
                    <td class="p-3 dark:text-gray-300 font-bold">{{ $grupo->horario->materia->nombre }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $grupo->horario->profesor->nombre }}</td>
                    <td class="p-3 dark:text-gray-300 text-sm">
                        {{ $grupo->horario->dias }} <br> 
                        <span class="text-blue-600 dark:text-blue-400 font-bold">
                            {{ \Carbon\Carbon::parse($grupo->horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($grupo->horario->hora_fin)->format('H:i') }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2 items-center h-full mt-2">
                        <a href="{{ route('grupos.editar', $grupo->id) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:text-blue-800 dark:hover:text-blue-300 transition-colors">Editar</a>
                        <form action="{{ route('grupos.eliminar', $grupo->id) }}" method="POST" class="inline">
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