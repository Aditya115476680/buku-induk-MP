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
    <title>@yield('title', 'Dashboard Guru')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>[x-cloak]{display:none!important;}</style>
</head>

<body class="bg-gray-100 dark:bg-brandDark text-gray-800 dark:text-white transition-colors duration-300">
<div class="flex h-screen">

    <aside class="w-64 flex flex-col bg-white dark:bg-brandDark transition-colors duration-300">
        <div class="p-6 flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full overflow-hidden shadow-lg border-2 border-white">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Sekolah" class="w-full h-full object-cover">
            </div>

            <h1 class="mt-4 text-lg font-semibold">Buku Induk</h1>
            <p class="text-xs text-gray-400 dark:text-gray-400">Panel Guru</p>

            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                <div class="font-semibold text-gray-700 dark:text-gray-200">{{ auth()->user()->name ?? '-' }}</div>
                <div>{{ auth()->user()->email ?? '-' }}</div>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('guru.dashboard') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-brandCard hover:translate-x-1 transition-all duration-200">
                Dashboard
            </a>

            <a href="{{ route('guru.kelas-saya') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-brandCard hover:translate-x-1 transition-all duration-200">
                Kelas Saya (Wali)
            </a>

            <a href="{{ route('guru.nilai.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-brandCard hover:translate-x-1 transition-all duration-200">
                Input Nilai
            </a>

            <a href="{{ route('guru.nilai.rekap') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-brandCard hover:translate-x-1 transition-all duration-200">
                Rekap Nilai
            </a>

            <a href="{{ route('guru.cetak.rapor') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-brandCard hover:translate-x-1 transition-all duration-200">
                Cetak Rapor
            </a>
        </nav>

        <div class="p-4 space-y-2">
            <button @click="toggle()"
                    class="w-full px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:opacity-90 transition">
                <span x-show="darkMode">Dark Mode</span>
                <span x-show="!darkMode">Light Mode</span>
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-brandAccent hover:opacity-90 text-white px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="flex justify-between items-center bg-white dark:bg-gray-800 px-6 py-4 shadow transition-colors duration-300">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-white">
                @yield('title', 'Dashboard Guru')
            </h2>
        </header>

        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
