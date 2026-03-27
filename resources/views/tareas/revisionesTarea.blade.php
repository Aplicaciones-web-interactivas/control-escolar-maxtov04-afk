@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    @if(session('exito'))
        <div id="alerta-exito" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm font-bold">
            {{ session('exito') }}
        </div>
    @endif
    @if($errors->any())
        <div id="alerta-error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm font-bold">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8 border border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-blue-600 dark:text-blue-400 uppercase tracking-tight">
                Revisiones: {{ $tarea->titulo }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400 font-mono text-sm mt-1">
                {{ $tarea->grupo->horario->materia->nombre }} - Grupo {{ $tarea->grupo->nombre }}
            </p>
        </div>
        <a href="{{ route('profesor.administrar', $tarea->grupo_id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded text-sm font-black transition-all uppercase shadow-sm">
            Volver a Tareas
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-black text-gray-800 dark:text-white uppercase tracking-tight">
                Alumnos que entregaron
            </h3>
            <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 px-3 py-1 rounded-full text-xs font-black">
                {{ $entregas->count() }} Entregas
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                    <tr>
                        <th class="p-4 text-xs font-black uppercase">Estudiante</th>
                        <th class="p-4 text-xs font-black uppercase text-center w-40">Archivo PDF</th>
                        <th class="p-4 text-xs font-black uppercase text-left w-72">Calificación y Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entregas as $entrega)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="p-4 dark:text-gray-300 font-bold align-middle">
                                {{ $entrega->usuario->nombre }}
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-mono font-normal mt-1">
                                    Enviado: {{ $entrega->created_at->format('d/m/Y h:i A') }}
                                </div>
                            </td>
                            <td class="p-4 text-center align-middle">
                                <a href="{{ asset('storage/' . $entrega->archivo_pdf) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded text-xs font-black transition-all uppercase shadow-sm">
                                    <i class="fa-solid fa-file-pdf"></i> Ver PDF
                                </a>
                            </td>
                            <td class="p-4 bg-gray-50 dark:bg-gray-900/50 border-l dark:border-gray-700">
                                <form action="{{ route('profesor.entregas.calificar', $entrega->id) }}" method="POST" class="flex flex-col gap-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="calificacion" value="{{ $entrega->calificacion }}" min="0" max="{{ $tarea->calificacion }}" placeholder="Nota" class="w-20 border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white font-black focus:ring-2 focus:ring-blue-500 outline-none text-center text-sm" required>
                                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">/ {{ $tarea->calificacion }}</span>
                                    </div>
                                    <textarea name="comentarios" rows="1" placeholder="Comentarios (Opcional)..." class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none text-xs">{{ $entrega->comentarios }}</textarea>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-black transition-all uppercase shadow-sm self-end">
                                        Guardar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-12 text-center text-gray-500 dark:text-gray-400 font-bold italic">
                                Aún no hay archivos entregados para esta actividad.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection