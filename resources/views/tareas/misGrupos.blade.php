@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors">Mis Grupos</h2>
        </div>
    </div>

    @if($grupos->isEmpty())
        <div class="bg-white dark:bg-gray-800 p-8 rounded shadow-md text-center text-gray-500 dark:text-gray-400 font-bold">
            No tienes grupos asignados en este momento.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($grupos as $grupo)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-black text-blue-600 dark:text-blue-400 uppercase mb-1">
                        {{ $grupo->horario->materia->nombre }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 font-mono text-sm mb-6">Grupo: {{ $grupo->nombre }}</p>
                </div>
                <a href="{{ route('profesor.administrar', $grupo->id) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-black transition-all uppercase shadow-sm">
                    Administrar
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection