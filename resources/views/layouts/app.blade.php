<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col font-sans transition-colors duration-300">

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300">
        <div class="w-full px-6 flex justify-between h-16 items-center">
            
            <div class="flex items-center gap-10">
                <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap fa-lg" style="color: rgb(255, 255, 255);"></i>
                    <span class="text-xl font-black tracking-tighter text-gray-900 dark:text-white transition-colors">Sistema Educativo</span>
                </a>

                @auth
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('materias.index') }}" class="text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Materias</a>
                    <a href="#" class="text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Grupos</a>
                    <a href="#" class="text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Horarios</a>
                </div>
                @endauth
            </div>

            <div class="flex items-center gap-6">
                @auth
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block border-r pr-4 border-gray-200 dark:border-gray-700 transition-colors">
                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100 leading-none mb-1">{{ Auth::user()->nombre }}</p>
                            <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ Auth::user()->rol }}</p>
                        </div>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-4 py-2 rounded hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-all border border-gray-200 dark:border-gray-600 hover:border-red-200 dark:hover:border-red-800">
                                SALIR
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Entrar</a>
                        <a href="{{ route('registro') }}" class="bg-gray-900 dark:bg-blue-600 text-white px-5 py-2 rounded font-bold text-sm hover:bg-black dark:hover:bg-blue-500 transition-all">
                            Registro
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </nav>
    @if(session('success'))
        <div id="alerta-exito" class="mb-6 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-3 rounded text-sm font-medium flex items-center gap-3 transition-opacity duration-500">
            <div class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400"></div>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div id="alerta-error" class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-5 py-3 rounded text-sm transition-opacity duration-500">
            <ul class="space-y-1 opacity-90 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('danger'))
        <div id="alerta-peligro" class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-5 py-3 rounded text-sm font-medium flex items-center gap-3 transition-opacity duration-500">
            <div class="w-2 h-2 rounded-full bg-red-500 dark:bg-red-400"></div>
            {{ session('danger') }}
        </div>
    @endif

    <main class="max-w-7xl mx-auto w-full py-8 px-4 sm:px-6 lg:px-8 grow">
        @yield('contenido')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertaExito = document.getElementById('alerta-exito');
            const alertaError = document.getElementById('alerta-error');
            const alertaPeligro = document.getElementById('alerta-peligro');
            const ocultarAlerta = (elemento) => {
                if (elemento) {
                    setTimeout(() => {
                        elemento.classList.add('opacity-0');
                        setTimeout(() => elemento.remove(), 500);
                    }, 3000);
                }
            };

            ocultarAlerta(alertaExito);
            ocultarAlerta(alertaError);
            ocultarAlerta(alertaPeligro);
        });
    </script>
</body>
</html>