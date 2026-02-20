<!DOCTYPE html>
<html lang="id"
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
        }
    }"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-brandDark text-gray-800 dark:text-white transition-colors duration-300">

<div class="flex h-screen">

    <aside class="w-64 flex flex-col bg-white dark:bg-brandDark transition-colors duration-300">

        <div class="p-6 flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full overflow-hidden shadow-lg border-2 border-white">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Sekolah" class="w-full h-full object-cover">
            </div>

            <h1 class="mt-4 text-lg font-semibold">Buku Induk</h1>
            <p class="text-xs text-gray-400 dark:text-gray-400">Mahaputra</p>
        </div>

        <nav class="flex-1 px-4 space-y-2"
             x-data="{ masterOpen: false, akademikOpen: false, cetakOpen: false }">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded-lg
               hover:bg-gray-200 dark:hover:bg-brandCard
               hover:text-brandDark dark:hover:text-white
               hover:translate-x-1 hover:shadow-sm
               transition-all duration-200">
               Dashboard
            </a>

            <button @click="masterOpen = !masterOpen"
                class="w-full text-left px-4 py-2 rounded-lg
                hover:bg-gray-200 dark:hover:bg-brandCard
                hover:text-brandDark dark:hover:text-white
                hover:translate-x-1 hover:shadow-sm
                transition-all duration-200
                flex justify-between items-center">
                <span>Data Master</span>
                <svg :class="{'rotate-180': masterOpen}"
                    class="w-4 h-4 transition-transform duration-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="masterOpen" x-transition class="ml-4 space-y-1 text-sm">

                <a href="#"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Data Siswa
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Data Guru
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Data Kelas
                </a>
            </div>

            <button @click="akademikOpen = !akademikOpen"
                class="w-full text-left px-4 py-2 rounded-lg mt-4
                hover:bg-gray-200 dark:hover:bg-brandCard
                hover:text-brandDark dark:hover:text-white
                hover:translate-x-1 hover:shadow-sm
                transition-all duration-200
                flex justify-between items-center">
                <span>Akademik</span>
                <svg :class="{'rotate-180': akademikOpen}"
                    class="w-4 h-4 transition-transform duration-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="akademikOpen" x-transition class="ml-4 space-y-1 text-sm">

                <a href="#"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Tahun Ajaran
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Semester
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Mata Pelajaran
                </a>
            </div>

            <button @click="cetakOpen = !cetakOpen"
                class="w-full text-left px-4 py-2 rounded-lg mt-4
                hover:bg-gray-200 dark:hover:bg-brandCard
                hover:text-brandDark dark:hover:text-white
                hover:translate-x-1 hover:shadow-sm
                transition-all duration-200
                flex justify-between items-center">
                <span>Cetak</span>
                <svg :class="{'rotate-180': cetakOpen}"
                    class="w-4 h-4 transition-transform duration-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="cetakOpen" x-transition class="ml-4 space-y-1 text-sm">

                <a href="{{ route('cetak.buku') }}"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Cetak Buku Induk
                </a>

                <a href="{{ route('cetak.siswa') }}"
                   class="block px-4 py-2 rounded-lg
                   hover:bg-gray-200 dark:hover:bg-brandCard
                   hover:text-brandDark dark:hover:text-white
                   transition-all duration-200">
                   Cetak Data Siswa
                </a>

            </div>

        </nav>

        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-brandAccent hover:opacity-90 text-white px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">

        <header class="flex justify-between items-center
            bg-white dark:bg-gray-800
            px-6 py-4 shadow transition-colors duration-300">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-white">
                @yield('title', 'Dashboard')
            </h2>

            <button @click="toggle()"
                class="relative inline-flex items-center gap-2 px-4 py-2 rounded-full
                bg-gray-200 dark:bg-gray-700
                shadow-md hover:scale-105
                transition-all duration-300">

                <span class="text-lg">
                    <span x-show="darkMode">🌙</span>
                    <span x-show="!darkMode">☀️</span>
                </span>

                <span class="text-sm font-semibold">
                    <span x-show="darkMode">Dark Mode</span>
                    <span x-show="!darkMode">Light Mode</span>
                </span>
            </button>
        </header>

        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>
</body>
</html>
