<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Buku Induk</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-brandDark shadow-md">
                <img src="{{ asset('images/logo.jpg') }}"
                     class="w-full h-full object-cover"
                     alt="Logo Sekolah">
            </div>

            <h1 class="mt-4 text-2xl font-bold text-brandDark">
                Buku Induk Siswa
            </h1>

            <p class="text-sm text-gray-500">
                SMK MAHAPUTRA CERDAS UTAMA
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">
                Login
            </h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" required autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brandDark outline-none">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brandDark outline-none">
                </div>

                <!-- Remember -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-sm text-gray-600">Remember me</span>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-brandAccent hover:opacity-90 text-white py-2 rounded-lg font-semibold transition">
                    LOGIN
                </button>

            </form>

        </div>

    </div>

</body>
</html>
