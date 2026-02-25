@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Data Siswa</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data siswa</p>
    </div>

    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-300">
                Halaman Data Siswa sudah siap.
            </div>
            <a href="{{ route('students.create') }}"
               class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
                + Tambah Siswa
            </a>
        </div>
    </div>
</div>
@endsection
