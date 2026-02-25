@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Dashboard Statistik</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan data terbaru</p>
    </div>

    {{-- Cards Kotak-kotak --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Jumlah Siswa --}}
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Siswa</p>
            <div class="mt-2 flex items-end justify-between">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahSiswa }}</h2>
                <span class="text-xs px-2 py-1 rounded-md bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300">
                    Siswa
                </span>
            </div>
        </div>

        {{-- Jumlah Kelas --}}
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Kelas</p>
            <div class="mt-2 flex items-end justify-between">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahKelas }}</h2>
                <span class="text-xs px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-300">
                    Kelas
                </span>
            </div>
        </div>

        {{-- Jumlah Mapel --}}
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Mapel</p>
            <div class="mt-2 flex items-end justify-between">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahMapel }}</h2>
                <span class="text-xs px-2 py-1 rounded-md bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300">
                    Mapel
                </span>
            </div>
        </div>

        {{-- Jumlah Nilai --}}
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Nilai</p>
            <div class="mt-2 flex items-end justify-between">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahNilai }}</h2>
                <span class="text-xs px-2 py-1 rounded-md bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300">
                    Nilai
                </span>
            </div>
        </div>
    </div>

    {{-- Rata-rata Nilai --}}
    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Nilai Siswa</p>
                <h2 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                    {{ number_format($rataNilai, 2) }}
                </h2>
            </div>

            <div class="text-right">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                    bg-gray-900 text-white dark:bg-white dark:text-gray-900">
                    Statistik
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
