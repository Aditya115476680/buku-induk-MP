@extends('layouts.app')
@section('title', 'Tambah Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Tambah Siswa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Isi data siswa baru</p>
        </div>

        <a href="{{ route('students.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 text-red-800 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 p-4">
            <div class="font-semibold mb-2">Periksa lagi input kamu:</div>
            <ul class="list-disc ml-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data"
          class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">NIS</label>
                <input type="text" name="nis" value="{{ old('nis') }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                              px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                              px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                              px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tempat Lahir</label>
                <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                              px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                              px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kelas (opsional)</label>
                <select name="current_class_id"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                               px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                    <option value="">- Pilih Kelas -</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" @selected(old('current_class_id') == $c->id)>
                            {{ $c->grade_level }} {{ $c->major->name ?? '' }} {{ $c->rombel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Foto</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5
                              px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maks 2MB (jpg/png).</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('students.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
