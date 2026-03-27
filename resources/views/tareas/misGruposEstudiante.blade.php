@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-black text-gray-800 dark:text-white">Mis Grupos (Tareas)</h2>
    </div>

    @if($inscripciones->isEmpty())
        <div class="bg-white dark:bg-gray-800 p-8 rounded shadow-md text-center text-gray-500 font-bold">
            No estás inscrito en ningún grupo actualmente.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($inscripciones as $inscripcion)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-black text-blue-600 dark:text-blue-400 uppercase mb-1">
                        {{ $inscripcion->grupo->horario->materia->nombre }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 font-mono text-sm mb-2">Grupo: {{ $inscripcion->grupo->nombre }}</p>
                    <p class="text-xs font-bold text-gray-400 mb-6">
                        Prof. {{ $inscripcion->grupo->horario->usuario->nombre }}
                    </p>
                </div>
                <a href="{{ route('estudiante.tareas', $inscripcion->grupo->id) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-black transition-all uppercase shadow-sm">
                    Ver Tareas
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection