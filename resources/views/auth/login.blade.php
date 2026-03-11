@extends('layouts.app')

@section('contenido')
<div class="mt-10 max-w-sm mx-auto bg-white dark:bg-gray-800 p-8 border border-gray-300 dark:border-gray-700 rounded shadow-sm transition-colors duration-300">
    <h2 class="text-lg font-bold mb-6 text-center border-b dark:border-gray-700 pb-2 dark:text-white transition-colors">INICIAR SESIÓN</h2>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold mb-1 uppercase text-gray-600 dark:text-gray-400 transition-colors">Clave Institucional</label>
            <input type="text" name="clave_institucional" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded outline-none focus:ring-1 focus:ring-gray-400 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500 transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold mb-1 uppercase text-gray-600 dark:text-gray-400 transition-colors">Contraseña</label>
            <input type="password" name="password" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded outline-none focus:ring-1 focus:ring-gray-400 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-500 transition-all" required>
        </div>
        <button type="submit" class="w-full bg-blue-700 dark:bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-800 dark:hover:bg-blue-500 transition-colors">
            ENTRAR
        </button>
    </form>

    <div class="mt-6 text-center text-xs">
        <p class="dark:text-gray-300 transition-colors">¿No tienes cuenta? <a href="{{ route('registro') }}" class="text-blue-700 dark:text-blue-400 font-bold underline hover:text-blue-800 dark:hover:text-blue-300 transition-colors">Regístrate</a></p>
    </div>
</div>
@endsection