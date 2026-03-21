@extends('layouts.app')

@section('contenido')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 p-6 rounded shadow-sm transition-colors duration-300">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white transition-colors">Panel de Control</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors">Gestión del sistema educativo.</p>
    </div>

    <div class="max-w-6xl mx-auto">

        @if(auth()->user()->rol === 'profesor' && $chisteChuckNorris)
            <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded shadow-md border-l-4 border-orange-500 transition-colors duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <img src="https://api.chucknorris.io/img/avatar/chuck-norris.png" alt="Chuck Norris" class="w-12 h-12 drop-shadow-md">
                    <h3 class="text-xl font-black text-gray-800 dark:text-white transition-colors">Dato curioso de Chuck Norris</h3>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-lg italic transition-colors">
                    "{{ $chisteChuckNorris }}"
                </p>
            </div>
        @endif

    </div>
</div>
@endsection