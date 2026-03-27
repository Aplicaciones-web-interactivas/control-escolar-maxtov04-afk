@extends('layouts.app')

@section('contenido')
<div class="space-y-8">
    
    <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 p-6 rounded shadow-sm transition-colors duration-300 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white transition-colors">
                ¡Hola, {{ auth()->user()->nombre }}!
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors mt-1">
                Panel de {{ ucfirst(auth()->user()->rol) }} - Gestión del sistema educativo.
            </p>
        </div>
        <div class="hidden md:block">
            @if(strtolower(auth()->user()->rol) == 'admin')
                <i class="fa-solid fa-shield-halved text-4xl text-indigo-500 opacity-20 transition-colors"></i>
            @elseif(strtolower(auth()->user()->rol) == 'profesor')
                <i class="fa-solid fa-chalkboard-user text-4xl text-emerald-500 opacity-20 transition-colors"></i>
            @else
                <i class="fa-solid fa-user-graduate text-4xl text-blue-500 opacity-20 transition-colors"></i>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto space-y-8">

        @if(strtolower(auth()->user()->rol) == 'admin')
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white uppercase mb-4 border-b dark:border-gray-700 pb-2 transition-colors">Gestión del Sistema</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('usuarios.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-indigo-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-users text-2xl text-indigo-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Usuarios</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Administrar cuentas de alumnos y profes.</p>
                    </a>
                    <a href="{{ route('materias.index') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-indigo-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-book text-2xl text-indigo-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Materias</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Gestionar el catálogo de materias.</p>
                    </a>
                    <a href="{{ route('grupos.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-indigo-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-layer-group text-2xl text-indigo-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Grupos</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Configurar grupos de estudio.</p>
                    </a>
                    <a href="{{ route('inscripciones.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-indigo-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-clipboard-list text-2xl text-indigo-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Inscripciones</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Inscribir alumnos a sus clases.</p>
                    </a>
                </div>
            </div>
        @endif

        @if(strtolower(auth()->user()->rol) == 'profesor')
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white uppercase mb-4 border-b dark:border-gray-700 pb-2 transition-colors">Tus Herramientas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <a href="{{ route('profesor.misGrupos') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-emerald-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-chalkboard text-2xl text-emerald-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Mis Grupos y Tareas</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Gestiona actividades y revisa entregas.</p>
                    </a>
                    <a href="{{ route('calificaciones.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-emerald-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-star text-2xl text-emerald-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Calificaciones</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Subir actas de evaluación final.</p>
                    </a>
                </div>
            </div>

            @if(!empty($chisteChuckNorris))
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md border-l-4 border-orange-500 transition-colors duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="https://api.chucknorris.io/img/avatar/chuck-norris.png" alt="Chuck Norris" class="w-12 h-12 drop-shadow-md">
                        <h3 class="text-xl font-black text-gray-800 dark:text-white transition-colors">Dato curioso de Chuck Norris</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-lg italic transition-colors">
                        "{{ $chisteChuckNorris }}"
                    </p>
                </div>
            @endif
        @endif

        @if(strtolower(auth()->user()->rol) == 'estudiante')
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white uppercase mb-4 border-b dark:border-gray-700 pb-2 transition-colors">Opciones</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('estudiante.misGrupos') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-blue-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-book-open text-2xl text-blue-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Mis Tareas</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Sube tus archivos PDF y revisa pendientes.</p>
                    </a>
                    <a href="{{ route('horarios.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-blue-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-clock text-2xl text-blue-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Mi Horario</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Consulta tus horas de clase.</p>
                    </a>
                    <a href="{{ route('calificaciones.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-blue-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-graduation-cap text-2xl text-blue-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Mis Calificaciones</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Mira tus notas finales del semestre.</p>
                    </a>
                    <a href="{{ route('grupos.lista') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-sm p-6 border-t-4 border-t-blue-500 hover:shadow-md transition-all group">
                        <i class="fa-solid fa-magnifying-glass text-2xl text-blue-500 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-bold text-gray-800 dark:text-white uppercase text-sm transition-colors">Oferta Académica</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors">Explora los grupos disponibles.</p>
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection