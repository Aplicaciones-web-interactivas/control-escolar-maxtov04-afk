@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md mb-8 transition-colors duration-300">
        <h2 class="text-xl font-bold mb-4 dark:text-white transition-colors">Registrar Nuevo Usuario</h2>
        <form action="{{ route('usuarios.guardar') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre Completo" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            
            <input type="text" name="clave_institucional" placeholder="Clave/Matrícula" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>

            <select name="rol" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>Selecciona Rol</option>
                <option value="admin">Administrador</option>
                <option value="profesor">Profesor</option>
                <option value="estudiante">Estudiante</option>
            </select>

            <input type="password" name="password" placeholder="Contraseña" class="border dark:border-gray-600 p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            
            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors font-bold">Crear Usuario</button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-hidden transition-colors duration-300">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-200 transition-colors">
                <tr>
                    <th class="p-3 text-sm uppercase">Clave</th>
                    <th class="p-3 text-sm uppercase">Nombre</th>
                    <th class="p-3 text-sm uppercase">Rol</th>
                    <th class="p-3 text-sm uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr class="border-t dark:border-gray-700 transition-colors">
                    <td class="p-3 dark:text-gray-300 font-bold italic text-sm">{{ $usuario->clave_institucional }}</td>
                    <td class="p-3 dark:text-gray-300">{{ $usuario->nombre }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $usuario->rol == 'admin' ? 'bg-purple-100 text-purple-700' : ($usuario->rol == 'profesor' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            {{ $usuario->rol }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('usuarios.editar', $usuario->id) }}" class="text-blue-600 dark:text-blue-400 font-bold hover:text-blue-800 dark:hover:text-blue-300 transition-colors">Editar</a>
                        
                        <form id="form-delete-{{ $usuario->id }}" action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" onclick="abrirModal({{ $usuario->id }})" class="text-red-600 dark:text-red-400 font-bold hover:text-red-800 dark:hover:text-red-300 transition-colors">Eliminar</button>
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
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Usuario</h3>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">¿Estás seguro de que deseas eliminar este usuario? Esta acción es irreversible.</p>
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
        if (formActual) { formActual.submit(); }
    }
</script>
@endsection