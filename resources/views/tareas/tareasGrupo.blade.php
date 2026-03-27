@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-100 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-black text-blue-600 dark:text-blue-400 uppercase">
                Tareas: {{ $grupo->horario->materia->nombre }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400 font-mono text-sm mt-1">Grupo: {{ $grupo->nombre }}</p>
        </div>
        <a href="{{ route('estudiante.misGrupos') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-black transition-all uppercase shadow-sm">
            Volver a Mis Grupos
        </a>
    </div>

    @if(session('exito'))
        <div class="alerta-mensaje bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm font-bold transition-opacity">
            {{ session('exito') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alerta-mensaje bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm font-bold transition-opacity">
            {{ $errors->first() }}
        </div>
    @endif

    @if($tareas->isEmpty())
        <div class="bg-white dark:bg-gray-800 p-8 rounded shadow-md text-center text-gray-500 font-bold">
            No hay tareas asignadas por el momento.
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($tareas as $tarea)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md flex flex-col border border-gray-100 dark:border-gray-700">
                    <div class="p-6 grow">
                        <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">{{ $tarea->titulo }}</h3>
                        
                        <div class="flex gap-2 mb-4 text-xs font-bold">
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded">
                                Límite: {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y h:i A') }}
                            </span>
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded">
                                {{ $tarea->calificacion }} pts
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 bg-gray-50 dark:bg-gray-900 p-3 rounded">
                            {{ $tarea->descripcion }}
                        </p>

                        @if($tarea->material_apoyo)
                            <a href="{{ asset('storage/' . $tarea->material_apoyo) }}" target="_blank" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline mb-4 block">
                                Ver Material de Apoyo
                            </a>
                        @endif
                    </div>

                    
                    <div class="p-6 border-t dark:border-gray-700 mt-auto bg-gray-50 dark:bg-gray-800">
                        @if($entregas->has($tarea->id))
                            @php $miEntrega = $entregas[$tarea->id]; @endphp

                            @if(is_null($miEntrega->calificacion))
                                <div id="estado-entregado-{{ $tarea->id }}">
                                    <div class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 p-3 rounded text-center font-black text-sm mb-4 border border-emerald-200 dark:border-emerald-800/50 shadow-inner">
                                        <i class="fa-solid fa-circle-check text-lg"></i> 
                                        ¡Tarea Entregada!
                                    </div>
                                    
                                    <div class="flex flex-col gap-3">
                                        <a href="{{ asset('storage/' . $miEntrega->archivo_pdf) }}" target="_blank" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm font-black transition-all uppercase shadow-sm text-center flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-file-pdf"></i> Ver archivo enviado
                                        </a>
                                        <button type="button" onclick="mostrarFormulario({{ $tarea->id }})" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-black transition-all uppercase shadow-sm flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-rotate"></i> Volver a entregar
                                        </button>
                                    </div>
                                </div>

                                <div id="form-reemplazo-{{ $tarea->id }}" class="hidden">
                                    <form action="{{ route('estudiante.tareas.entregar', $tarea->id) }}" method="POST" enctype="multipart/form-data" class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded border border-yellow-200 dark:border-yellow-800/50">
                                        @csrf
                                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">Sube tu nuevo archivo (Solo PDF)</label>
                                        <input type="file" name="archivo_pdf" accept=".pdf" class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:font-black file:bg-white dark:file:bg-gray-700 dark:file:text-white file:text-yellow-700 hover:file:bg-gray-50 mb-4 transition-colors outline-none" required>
                                        
                                        <div class="flex gap-2">
                                            <button type="button" onclick="ocultarFormulario({{ $tarea->id }})" class="w-1/3 bg-gray-500 hover:bg-gray-600 text-white px-2 py-2 rounded text-xs font-black transition-all uppercase shadow-sm">
                                                Cancelar
                                            </button>
                                            <button type="submit" class="w-2/3 bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-2 rounded text-xs font-black transition-all uppercase shadow-sm flex justify-center items-center gap-2">
                                                <i class="fa-solid fa-cloud-arrow-up"></i> Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded border border-blue-200 dark:border-blue-800/50">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-xs font-black text-gray-500 dark:text-gray-400 uppercase">Calificación:</span>
                                        <span class="text-xl font-black text-blue-600 dark:text-blue-400">
                                            {{ $miEntrega->calificacion }} <span class="text-sm text-gray-500">/ {{ $tarea->calificacion }}</span>
                                        </span>
                                    </div>
                                    
                                    @if($miEntrega->comentarios)
                                        <div class="bg-white dark:bg-gray-800 p-3 rounded border dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300 italic flex gap-2">
                                            <i class="fa-solid fa-quote-left text-gray-400 mt-1 text-xs"></i>
                                            <span>{{ $miEntrega->comentarios }}</span>
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-500 text-center italic mt-2">Revisado (Sin comentarios)</div>
                                    @endif
                                </div>
                            @endif

                        @else
                            <form action="{{ route('estudiante.tareas.entregar', $tarea->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">Sube tu trabajo (Solo PDF)</label>
                                <input type="file" name="archivo_pdf" accept=".pdf" class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-4 transition-colors outline-none cursor-pointer" required>
                                
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded text-sm font-black transition-all uppercase shadow-sm flex justify-center items-center gap-2">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Entregar Tarea
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function mostrarFormulario(tareaId) {
        document.getElementById('estado-entregado-' + tareaId).classList.add('hidden');
        document.getElementById('form-reemplazo-' + tareaId).classList.remove('hidden');
    }

    function ocultarFormulario(tareaId) {
        document.getElementById('form-reemplazo-' + tareaId).classList.add('hidden');
        document.getElementById('estado-entregado-' + tareaId).classList.remove('hidden');
    }
</script>
@endsection