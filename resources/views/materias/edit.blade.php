@extends('layouts.app')

@section('contenido')
<div class="max-w-md mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md transition-colors duration-300">
        <h2 class="text-xl font-bold mb-4 dark:text-white transition-colors">Editar Materia</h2>
        
        <form action="{{ route('materias.actualizar', $materia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Nombre de la Materia:</label>
                <input type="text" name="nombre" value="{{ $materia->nombre }}" 
                       class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 transition-colors">Clave:</label>
                <input type="text" name="clave" value="{{ $materia->clave }}" 
                       class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('materias.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-200 transition-colors">Cancelar</a>
                <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                    Actualizar Cambios
                </button>
            </div>
        </form>
    </div>
</div> 
@endsection