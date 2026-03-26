@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <i class="fa-solid fa-file-invoice text-2xl text-emerald-600 dark:text-emerald-400"></i>
        <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors">Mi Boleta de Calificaciones</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
        @if($misCalificaciones->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-folder-open text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 font-bold">Aún no tienes materias inscritas o calificaciones registradas.</p>
                <a href="{{ route('grupos.lista') }}" class="mt-4 inline-block text-blue-600 dark:text-blue-400 font-black hover:underline uppercase text-sm">Ir a inscripciones</a>
            </div>
        @else
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="p-5 text-xs font-black uppercase tracking-wider">Materia</th>
                        <th class="p-5 text-xs font-black uppercase tracking-wider">Profesor</th>
                        <th class="p-5 text-xs font-black uppercase tracking-wider text-center">Calificación</th>
                        <th class="p-5 text-xs font-black uppercase tracking-wider text-right">Estatus</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    @foreach($misCalificaciones as $nota)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="p-5">
                            <div class="font-black text-gray-900 dark:text-white">{{ $nota->grupo->horario->materia->nombre }}</div>
                            <div class="text-[10px] text-blue-600 dark:text-blue-400 font-bold uppercase">{{ $nota->grupo->nombre }}</div>
                        </td>
                        <td class="p-5 text-sm dark:text-gray-300 font-medium">
                            {{ $nota->grupo->horario->profesor->nombre }}
                        </td>
                        <td class="p-5 text-center">
                            <span class="text-xl font-black {{ $nota->calificacion >= 6 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $nota->calificacion ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="p-5 text-right">
                            @if(is_null($nota->calificacion))
                                <span class="text-[10px] font-black bg-gray-100 dark:bg-gray-700 text-gray-500 px-3 py-1 rounded-full uppercase">Pendiente</span>
                            @elseif($nota->calificacion >= 6)
                                <span class="text-[10px] font-black bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 px-3 py-1 rounded-full uppercase tracking-widest">Aprobado</span>
                            @else
                                <span class="text-[10px] font-black bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 px-3 py-1 rounded-full uppercase tracking-widest">Reprobado</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 border-t dark:border-gray-700 flex justify-between items-center">
                <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase">Promedio General</span>
                <span class="text-2xl font-black text-gray-900 dark:text-white">
                    {{ number_format($misCalificaciones->avg('calificacion'), 1) }}
                </span>
            </div>
        @endif
    </div>
</div>
@endsection