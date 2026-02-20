@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
        <p class="text-gray-500 dark:text-gray-400">Total Siswa</p>
        <h2 class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalStudents }}
        </h2>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
        <p class="text-gray-500 dark:text-gray-400">Total Guru</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalTeachers }}
        </h2>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
        <p class="text-gray-500 dark:text-gray-400">Total Kelas</p>
        <h2 class="text-3xl font-bold text-purple-600 mt-2">
            {{ $totalClasses }}
        </h2>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
        <p class="text-gray-500 dark:text-gray-400">Total Jurusan</p>
        <h2 class="text-3xl font-bold text-pink-600 mt-2">
            {{ $totalMajors }}
        </h2>
    </div>

</div>

@endsection
