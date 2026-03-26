@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <i class="fa-solid fa-calendar-days text-2xl text-blue-600 dark:text-blue-400"></i>
        <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors">Mi Horario de Clases</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-hidden transition-colors duration-300">
        @if($misGrupos->isEmpty())
            <div class="p-8 text-center text-gray-500 dark:text-gray-400 font-bold">
                Aún no estás inscrito en ningún grupo. Ve a "Oferta Académica" para inscribirte.
            </div>
        @else
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-200 transition-colors">
                    <tr>
                        <th class="p-3">Materia</th>
                        <th class="p-3">Grupo</th>
                        <th class="p-3">Profesor</th>
                        <th class="p-3">Días y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($misGrupos as $grupo)
                    <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="p-3 dark:text-gray-300 font-bold">{{ $grupo->horario->materia->nombre }}</td>
                        <td class="p-3 dark:text-gray-300 font-black text-blue-600">{{ $grupo->nombre }}</td>
                        <td class="p-3 dark:text-gray-300">{{ $grupo->horario->profesor->nombre }}</td>
                        <td class="p-3 dark:text-gray-300 text-sm">
                            {{ $grupo->horario->dias }} <br> 
                            <span class="text-gray-600 dark:text-gray-400 font-bold">
                                {{ \Carbon\Carbon::parse($grupo->horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($grupo->horario->hora_fin)->format('H:i') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection