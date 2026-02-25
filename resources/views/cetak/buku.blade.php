@extends('layouts.app')
@section('title', 'Cetak Buku Induk')

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Cetak Buku Induk</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Pilih siswa, lalu cetak buku induk</p>
    </div>

    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-4">
        <form method="GET" action="{{ route('students.index') }}" class="flex flex-col md:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}"
                   class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                          text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40"
                   placeholder="Cari siswa (nama / NIS / NISN) di halaman Data Siswa…">
            <button class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
                Cari
            </button>
        </form>

        <div class="text-sm text-gray-600 dark:text-gray-300">
            Untuk cetak, buka menu <span class="font-medium">Data Siswa</span> lalu klik tombol cetak pada siswa yang dipilih.
        </div>

        <div class="rounded-lg bg-gray-50 dark:bg-white/5 p-4 text-sm text-gray-700 dark:text-gray-200 space-y-2">
            <div class="font-semibold">Catatan</div>
            <div>Route cetak per siswa yang sudah ada di project kamu: <code>/cetak/buku/{id}</code></div>
        </div>
    </div>
</div>
@endsection
