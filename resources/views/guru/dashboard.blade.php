@extends('layouts.guru')
@section('title', 'Dashboard Guru')

@section('content')
@php($user = auth()->user())

<div class="space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Dashboard Guru</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Selamat datang, <span class="font-semibold">{{ $user->name }}</span>
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">Role</div>
            <div class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ method_exists($user, 'getRoleNames') ? $user->getRoleNames()->implode(', ') : '-' }}
            </div>
        </div>

        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">Email</div>
            <div class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ $user->email }}
            </div>
        </div>

        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">Aksi cepat</div>
            <div class="mt-3 flex gap-2 flex-wrap">
                <a href="{{ route('cetak.buku') }}"
                   class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
                    Cetak Buku Induk
                </a>
                <a href="{{ route('cetak.siswa') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
                    Cetak Data Siswa
                </a>
            </div>
        </div>
    </div>

    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
        <div class="text-sm font-semibold text-gray-800 dark:text-white mb-1">Info</div>
        <div class="text-sm text-gray-600 dark:text-gray-300">
            Halaman ini khusus untuk guru. Konten bisa kamu isi nanti (mis. jadwal mengajar, wali kelas, rekap nilai, dll).
        </div>
    </div>
</div>
@endsection
