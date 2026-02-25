@extends('layouts.app')
@section('title', 'Tambah Mapel')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Tambah Mata Pelajaran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Isi data mapel</p>
        </div>

        <a href="{{ route('subjects.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 text-red-800 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 p-4">
            <ul class="list-disc ml-5 text-sm space-y-1">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subjects.store') }}" method="POST"
          class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-5">
        @csrf

        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama Mapel</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                          text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Jurusan</label>
            <select name="major_id"
                    class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                           text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                <option value="">- Pilih Jurusan -</option>
                @foreach($majors as $m)
                    <option value="{{ $m->id }}" @selected(old('major_id') == $m->id)>{{ $m->code }} - {{ $m->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tipe</label>
            <select name="type"
                    class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                           text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                <option value="">- Pilih -</option>
                <option value="Wajib" @selected(old('type') === 'Wajib')>Wajib</option>
                <option value="Peminatan" @selected(old('type') === 'Peminatan')>Peminatan</option>
                <option value="Muatan Lokal" @selected(old('type') === 'Muatan Lokal')>Muatan Lokal</option>
            </select>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('subjects.index') }}"
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
