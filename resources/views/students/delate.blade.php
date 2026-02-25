@extends('layouts.app')
@section('title', 'Hapus Siswa')

@section('content')
<div class="max-w-2xl space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Hapus Siswa</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Konfirmasi sebelum menghapus data.
        </p>
    </div>

    <div class="rounded-xl border border-red-200 bg-red-50 dark:border-red-500/30 dark:bg-red-500/10 p-5">
        <div class="text-sm text-red-800 dark:text-red-200">
            Data yang sudah dihapus tidak bisa dikembalikan.
        </div>
    </div>

    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-4">
        <div class="text-sm text-gray-700 dark:text-gray-200">
            Yakin mau hapus siswa ini?
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-300">
            <div><span class="text-gray-500">Nama:</span> {{ $student->name }}</div>
            <div><span class="text-gray-500">NIS:</span> {{ $student->nis }}</div>
            <div><span class="text-gray-500">NISN:</span> {{ $student->nisn }}</div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('students.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
                Batal
            </a>

            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus siswa ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
