@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md mb-8 transition-colors duration-300">
        <h2 class="text-xl font-bold mb-4 dark:text-white transition-colors">Programar Nuevo Horario</h2>
        <form action="{{ route('horarios.guardar') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            
            <select name="materia_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>Selecciona una Materia</option>
                @foreach($materias as $materia)
                    <option value="{{ $materia->id }}">({{ $materia->clave }}) {{ $materia->nombre }} </option>
                @endforeach
            </select>

            <select name="usuario_id" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>Asignar Profesor</option>
                @foreach($profesores as $profesor)
                    <option value="{{ $profesor->id }}">({{$profesor->clave_institucional}}) {{ $profesor->nombre }}</option>
                @endforeach
            </select>

            <div class="md:col-span-3 flex flex-wrap gap-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded border dark:border-gray-600 items-center transition-colors">
                <span class="text-sm dark:text-gray-300 font-bold mr-2">Días:</span>
                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                    <label class="flex items-center gap-2 cursor-pointer text-sm dark:text-gray-300 hover:text-blue-600 transition-colors">
                        <input type="checkbox" name="dias[]" value="{{ $dia }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-500">
                        {{ $dia }}
                    </label>
                @endforeach
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-sm dark:text-gray-300 font-bold">De:</span>
                <input type="time" name="hora_inicio" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-sm dark:text-gray-300 font-bold">A:</span>
                <input type="time" name="hora_fin" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors self-end h-10.5">Guardar Horario</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-hidden transition-colors duration-300">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-200 transition-colors">
                <tr>
                    <th class="p-3">Materia</th>
                    <th class="p-3">Profesor</th>
                    <th class="p-3">Días</th>
                    <th class="p-3">Horario</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                <tr class="border-t dark:border-gray-700 transition-colors">
                    <td class="p-3 dark:text-gray-300 font-bold">{{ $horario->materia->nombre }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $horario->profesor->nombre }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $horario->dias }}</td>
                    <td class="p-3 dark:text-gray-300">{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('horarios.editar', $horario->id) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:text-blue-800 dark:hover:text-blue-300 transition-colors">Editar</a>
                        
                        <form id="form-delete-{{ $horario->id }}" action="{{ route('horarios.eliminar', $horario->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" onclick="abrirModal({{ $horario->id }})" class="text-red-600 dark:text-red-400 font-bold hover:text-red-800 dark:hover:text-red-300 transition-colors">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 mx-4 transform transition-all">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Horario</h3>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
            Si eliminas este horario, <span class="font-bold text-red-600 dark:text-red-400">también se borrarán permanentemente todos los GRUPOS</span> que estén ligados a él.<br><br>¿Estás completamente seguro de continuar?
        </p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Cancelar</button>
            <button type="button" onclick="confirmarEliminacion()" class="px-4 py-2 bg-red-600 text-white rounded font-bold hover:bg-red-700 transition-colors">Sí, eliminar</button>
        </div>
    </div>
</div>

<script>
    let formActual = null;
    const modal = document.getElementById('modal-delete');

    function abrirModal(id) {
        formActual = document.getElementById('form-delete-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModal() {
        formActual = null;
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function confirmarEliminacion() {
        if (formActual) {
            formActual.submit();
        }
    }
</script>
@endsection