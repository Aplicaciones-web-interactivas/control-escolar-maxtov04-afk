@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md mb-8 transition-colors duration-300">
        <h2 class="text-xl font-bold mb-4 dark:text-white transition-colors">Agregar Nueva Materia</h2>
        <form action="{{ route('materias.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre de la Materia" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            <input type="text" name="clave" placeholder="Clave (Ej: 200801)" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">Guardar</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-hidden transition-colors duration-300">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-200 transition-colors">
                <tr>
                    <th class="p-3">Clave</th>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materias as $materia)
                <tr class="border-t dark:border-gray-700 transition-colors">
                    <td class="p-3 dark:text-gray-300">{{ $materia->clave }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $materia->nombre }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('materias.editar', $materia->id) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:text-blue-800 dark:hover:text-blue-300 transition-colors">Editar</a>
                        <form action="{{ route('materias.eliminar', $materia->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 dark:text-red-400 font-bold hover:text-red-800 dark:hover:text-red-300 transition-colors">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection