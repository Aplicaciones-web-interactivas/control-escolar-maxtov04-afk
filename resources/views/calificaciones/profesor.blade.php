@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-pen-to-square text-2xl text-blue-600 dark:text-blue-400"></i>
            <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors">Panel de Calificaciones</h2>
        </div>
    </div>

    @if($calificaciones->isEmpty())
        <div class="bg-white dark:bg-gray-800 p-8 rounded shadow-md text-center text-gray-500 dark:text-gray-400 font-bold">
            No hay alumnos inscritos en tus grupos actualmente.
        </div>
    @else
        <div class="grid gap-6">
            @foreach($misGrupos as $grupo)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b dark:border-gray-700">
                    <h3 class="text-lg font-black text-blue-600 dark:text-blue-400 uppercase tracking-tight">
                        {{ $grupo->nombre }} - {{ $grupo->horario->materia->nombre }}
                    </h3>
                </div>
                
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                        <tr>
                            <th class="p-4 text-xs font-black uppercase">Matrícula</th>
                            <th class="p-4 text-xs font-black uppercase">Nombre del Estudiante</th>
                            <th class="p-4 text-xs font-black uppercase text-center w-40">Calificación</th>
                            <th class="p-4 text-xs font-black uppercase text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calificaciones->where('grupo_id', $grupo->id) as $nota)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="p-4 dark:text-gray-300 font-mono text-sm">{{ $nota->usuario->clave_institucional }}</td>
                            <td class="p-4 dark:text-gray-300 font-bold">{{ $nota->usuario->nombre }}</td>
                            <form action="{{ route('calificaciones.actualizar', $nota->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td class="p-4 text-center">
                                    <input type="number" name="calificacion" step="0.1" min="0" max="10" 
                                           value="{{ $nota->calificacion }}" 
                                           class="w-20 text-center border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white font-black focus:ring-2 focus:ring-blue-500 outline-none">
                                </td>
                                <td class="p-4 text-right">
                                    <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded text-xs font-black hover:bg-blue-700 transition-all uppercase shadow-sm">
                                        Guardar
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection