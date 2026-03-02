<!DOCTYPE html>
<html lang="id"
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
        }
    }"
    :class="{ 'dark': darkMode }"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        :root { color-scheme: light; }
        html.dark { color-scheme: dark; }

        html.dark select option {
            background-color: #0f172a;
            color: #e5e7eb;
        }
        html.dark select {
            background-color: rgba(255,255,255,.05);
            color: #ffffff;
        }

        /* Hide scrollbar tapi tetap bisa scroll */
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-brandDark text-gray-800 dark:text-white transition-colors duration-300">
<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen flex flex-col bg-white dark:bg-brandDark transition-colors duration-300 overflow-hidden">
        <div class="p-6 flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full overflow-hidden shadow-lg border-2 border-white">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Sekolah" class="w-full h-full object-cover">
            </div>

            <h1 class="mt-4 text-lg font-semibold">Buku Induk</h1>
            <p class="text-xs text-gray-400 dark:text-gray-400">Mahaputra</p>
        </div>

        <!-- NAV: scroll terpisah + hide scrollbar -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto no-scrollbar pb-4"
             x-data="{
                masterOpen: localStorage.getItem('sidebar_master_open') === 'true',
                akademikOpen: localStorage.getItem('sidebar_akademik_open') === 'true',
                cetakOpen: localStorage.getItem('sidebar_cetak_open') === 'true',

                toggleMaster() {
                    this.masterOpen = !this.masterOpen;
                    localStorage.setItem('sidebar_master_open', this.masterOpen);
                },
                toggleAkademik() {
                    this.akademikOpen = !this.akademikOpen;
                    localStorage.setItem('sidebar_akademik_open', this.akademikOpen);
                },
                toggleCetak() {
                    this.cetakOpen = !this.cetakOpen;
                    localStorage.setItem('sidebar_cetak_open', this.cetakOpen);
                }
             }"
        >
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg
                      hover:bg-gray-200 dark:hover:bg-brandCard
                      hover:text-brandDark dark:hover:text-white
                      hover:translate-x-1 hover:shadow-sm transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10.5L12 3l9 7.5V21a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V10.5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 22.5V12h6v10.5"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <button type="button"
                    @click="toggleMaster()"
                    class="w-full text-left px-4 py-2 rounded-lg
                           hover:bg-gray-200 dark:hover:bg-brandCard
                           hover:text-brandDark dark:hover:text-white
                           hover:translate-x-1 hover:shadow-sm
                           transition-all duration-200 flex justify-between items-center">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Data Master</span>
                </span>

                <svg :class="{'rotate-180': masterOpen}"
                     class="w-4 h-4 transition-transform duration-300"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-cloak x-show="masterOpen" x-transition class="ml-4 space-y-1 text-sm">
                <a href="{{ route('students.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 20H2v-2a4 4 0 014-4h3"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 3.13a4 4 0 010 7.75"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Data Siswa</span>
                </a>

                <a href="{{ route('teachers.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 10.5V16c0 1.5 3 3 6 3s6-1.5 6-3v-5.5"/>
                    </svg>
                    <span>Data Guru</span>
                </a>

                <a href="{{ route('classes.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 10h16M4 14h10M4 18h10"/>
                    </svg>
                    <span>Data Kelas</span>
                </a>
            </div>

            <button type="button"
                    @click="toggleAkademik()"
                    class="w-full text-left px-4 py-2 rounded-lg mt-4
                           hover:bg-gray-200 dark:hover:bg-brandCard
                           hover:text-brandDark dark:hover:text-white
                           hover:translate-x-1 hover:shadow-sm
                           transition-all duration-200 flex justify-between items-center">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 10.5V16c0 1.5 3 3 6 3s6-1.5 6-3v-5.5"/>
                    </svg>
                    <span>Akademik</span>
                </span>

                <svg :class="{'rotate-180': akademikOpen}"
                     class="w-4 h-4 transition-transform duration-300"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-cloak x-show="akademikOpen" x-transition class="ml-4 space-y-1 text-sm">
                <a href="{{ route('academic-years.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7h8M8 11h8M8 15h6"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                    <span>Tahun Ajaran</span>
                </a>

                <a href="{{ route('semesters.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3M5 11h14"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                    </svg>
                    <span>Semester</span>
                </a>

                <a href="{{ route('subjects.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6l-2 4-4 .5 3 3-.8 4.5L12 16l3.8 2-0.8-4.5 3-3-4-.5-2-4z"/>
                    </svg>
                    <span>Mata Pelajaran</span>
                </a>
            </div>

            <button type="button"
                    @click="toggleCetak()"
                    class="w-full text-left px-4 py-2 rounded-lg mt-4
                           hover:bg-gray-200 dark:hover:bg-brandCard
                           hover:text-brandDark dark:hover:text-white
                           hover:translate-x-1 hover:shadow-sm
                           transition-all duration-200 flex justify-between items-center">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 9V2h12v7"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18h12v4H6v-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 13H4a2 2 0 01-2-2V9a2 2 0 012-2h16a2 2 0 012 2v2a2 2 0 01-2 2h-2"/>
                    </svg>
                    <span>Cetak</span>
                </span>

                <svg :class="{'rotate-180': cetakOpen}"
                     class="w-4 h-4 transition-transform duration-300"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-cloak x-show="cetakOpen" x-transition class="ml-4 space-y-1 text-sm">
                <a href="{{ route('cetak.buku') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                    </svg>
                    <span>Cetak Buku Induk</span>
                </a>

                <a href="{{ route('cetak.siswa') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg
                          hover:bg-gray-200 dark:hover:bg-brandCard
                          hover:text-brandDark dark:hover:text-white
                          transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7h8M8 11h8M8 15h6"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                    <span>Cetak Data Siswa</span>
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

    <!-- MAIN -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex justify-between items-center bg-white dark:bg-gray-800 px-6 py-4 shadow transition-colors duration-300">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-white">
                @yield('title', 'Dashboard')
            </h2>

            <button @click="toggle()"
                    class="relative inline-flex items-center gap-2 px-4 py-2 rounded-full
                           bg-gray-200 dark:bg-gray-700 shadow-md hover:scale-105 transition-all duration-300">
                <span class="text-sm font-semibold">
                    <span x-show="darkMode">Dark Mode</span>
                    <span x-show="!darkMode">Light Mode</span>
                </span>
            </button>
        </header>

        <main class="flex-1 p-6 overflow-y-auto no-scrollbar">
            @yield('content')
        </main>

        @if (session('success'))
            <div class="fixed top-4 right-4 z-50 rounded-xl border border-green-200 bg-green-50 text-green-800 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-200 p-4 shadow-lg max-w-sm mx-auto sm:mx-0 transition-all">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    document.querySelector('.fixed.top-4.right-4')?.remove();
                }, 4000);
            </script>
        @endif
    </div>

</div>
</body>
</html>
