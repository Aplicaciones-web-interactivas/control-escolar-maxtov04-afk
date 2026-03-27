@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-100 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-black text-blue-600 dark:text-blue-400 uppercase">
                Administrar Tareas
            </h2>
            <p class="text-gray-500 dark:text-gray-400 font-mono text-sm mt-1">
                {{ $grupo->horario->materia->nombre }} - Grupo {{ $grupo->nombre }}
            </p>
        </div>
        <a href="{{ route('profesor.misGrupos') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-black transition-all uppercase shadow-sm">
            Volver a Mis Grupos
        </a>
    </div>

    @if(session('exito'))
        <div class="alerta-mensaje bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            <p class="font-bold">{{ session('exito') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-5">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-100 dark:border-gray-700 p-6 sticky top-6">
                <h3 class="text-lg font-black text-gray-800 dark:text-white uppercase mb-4 border-b pb-2 dark:border-gray-700">
                    Nueva Tarea
                </h3>
                
                <form action="{{ route('profesor.tareas.store', $grupo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Título de la Tarea</label>
                        <input type="text" name="titulo" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Fecha de Entrega</label>
                            <input type="datetime-local" name="fecha_entrega" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Calificación (Puntos)</label>
                            <input type="number" name="calificacion" value="100" min="1" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Material de Apoyo (Opcional)</label>
                        <input type="file" name="material_apoyo" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-600 dark:file:text-white outline-none border dark:border-gray-600 rounded p-1">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Descripción / Instrucciones</label>
                        <textarea name="descripcion" rows="4" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded text-sm font-black transition-all uppercase shadow-sm">
                        Asignar Tarea
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-black text-gray-800 dark:text-white uppercase mb-4 border-b pb-2 dark:border-gray-700">
                    Historial de Tareas
                </h3>

                @if($tareas->isEmpty())
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400 font-bold">
                        Aún no has asignado tareas a este grupo.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($tareas as $tarea)
                            <div class="border dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-black text-lg text-blue-600 dark:text-blue-400">{{ $tarea->titulo }}</h4>
                                    <span class="bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-300 px-2 py-1 rounded text-xs font-bold">
                                        Valor: {{ $tarea->calificacion }} pts
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-bold mb-3">
                                    Fecha límite: {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y h:i A') }}
                                </p>

                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 bg-gray-50 dark:bg-gray-900 p-3 rounded border dark:border-gray-600">
                                    {{ $tarea->descripcion }}
                                </p>

                                @if($tarea->material_apoyo)
                                    <div class="mb-4">
                                        <a href="{{ asset('storage/' . $tarea->material_apoyo) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                            </svg>
                                            Ver Material Adjunto
                                        </a>
                                    </div>
                                @endif

                                <div class="flex gap-2">
                                    <a href="{{ route('profesor.tareas.revisiones', $tarea->id) }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded text-xs font-black uppercase transition-all shadow-sm">
                                        Revisar
                                    </a>
                                    
                                    <a href="{{ route('profesor.tareas.editar', $tarea->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-black uppercase transition-all shadow-sm">
                                        Editar
                                    </a>
                                    
                                    <button type="button" onclick="abrirModalEliminar('{{ route('profesor.tareas.eliminar', $tarea->id) }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-black uppercase transition-all shadow-sm">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<div id="modalEliminar" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md border border-gray-100 dark:border-gray-700 transform transition-all">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-red-600 dark:text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase">¿Eliminar esta tarea?</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Esta acción no se puede deshacer. Se eliminarán permanentemente las instrucciones y el material adjunto.
            </p>
        </div>
        <div class="flex gap-3 justify-center">
            <button type="button" onclick="cerrarModalEliminar()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white px-4 py-2 rounded font-black text-sm uppercase transition-colors">
                Cancelar
            </button>
            <form id="formEliminar" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-black text-sm uppercase transition-colors shadow-sm">
                    Sí, Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function abrirModalEliminar(ruta) {
        document.getElementById('formEliminar').action = ruta;
        let modal = document.getElementById('modalEliminar');
        modal.classList.remove('hidden');
        modal.classList.add('flex'); 
    }

    function cerrarModalEliminar() {
        let modal = document.getElementById('modalEliminar');
        modal.classList.add('hidden'); 
        modal.classList.remove('flex'); 
    }
</script>
@endsection