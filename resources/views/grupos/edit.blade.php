@extends('layouts.app')

@section('contenido')
<div class="max-w-xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md transition-colors duration-300">
        <h2 class="text-xl font-bold mb-6 dark:text-white transition-colors">Editar Grupo</h2>
        
        <form action="{{ route('grupos.actualizar', $grupo->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Nombre del Grupo:</label>
                <input type="text" name="nombre" value="{{ $grupo->nombre }}" 
                       class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Horario Asignado:</label>
                <select name="horario_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    <option value="" disabled>Selecciona un Horario</option>
                    @foreach($horarios as $horario)
                        <option value="{{ $horario->id }}" {{ $grupo->horario_id == $horario->id ? 'selected' : '' }}>
                            {{ $horario->materia->nombre }} - {{ $horario->profesor->nombre }} ({{ $horario->dias }}) de {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}-{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center mt-6 pt-4 border-t dark:border-gray-700 transition-colors">
                <a href="{{ route('grupos.lista') }}" class="text-gray-600 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-200 transition-colors">Cancelar</a>
                <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                    Actualizar Grupo
                </button>
            </div>
        </form>
    </div>
</div> 
@endsection