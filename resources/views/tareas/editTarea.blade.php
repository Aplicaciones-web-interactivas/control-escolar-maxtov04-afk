@extends('layouts.app')

@section('contenido')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-black text-blue-600 dark:text-blue-400 uppercase">
                Editar Tarea
            </h3>
            <a href="{{ route('profesor.administrar', $tarea->grupo_id) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400">
                Cancelar y Volver
            </a>
        </div>
        <div class="p-6">
            <form action="{{ route('profesor.tareas.actualizar', $tarea->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Título de la Tarea</label>
                    <input type="text" name="titulo" value="{{ $tarea->titulo }}" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Fecha de Entrega</label>
                        <input type="datetime-local" name="fecha_entrega" value="{{ date('Y-m-d\TH:i', strtotime($tarea->fecha_entrega)) }}" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Calificación (Puntos)</label>
                        <input type="number" name="calificacion" value="{{ $tarea->calificacion }}" min="1" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                </div>

                <div class="mb-4 bg-gray-50 dark:bg-gray-900 p-4 border dark:border-gray-700 rounded">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Reemplazar Material de Apoyo (Opcional)</label>
                    @if($tarea->material_apoyo)
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-bold mb-2">Ya existe un archivo adjunto. Si subes uno nuevo, se reemplazará.</p>
                    @endif
                    <input type="file" name="material_apoyo" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-black file:bg-blue-50 file:text-blue-700 outline-none">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Descripción / Instrucciones</label>
                    <textarea name="descripcion" rows="5" class="w-full border dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" required>{{ $tarea->descripcion }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded text-sm font-black transition-all uppercase shadow-sm">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</div>
@endsection