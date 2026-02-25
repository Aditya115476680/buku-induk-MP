@extends('layouts.app')
@section('title', 'Data Kelas')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Data Kelas</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data kelas</p>
        </div>

        <a href="{{ route('classes.create') }}"
           class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
            + Tambah Kelas
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200 p-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 text-red-800 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200 p-4">
            <ul class="list-disc ml-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('classes.index') }}"
          class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Cari (jurusan / rombel)</label>
                <input type="text" name="q" value="{{ $q }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                              text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40"
                       placeholder="Contoh: RPL / TKJ / 1 / 2 ...">
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tingkat</label>
                <select name="grade"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                               text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                    <option value="">Semua</option>
                    <option value="X" @selected($grade === 'X')>X</option>
                    <option value="XI" @selected($grade === 'XI')>XI</option>
                    <option value="XII" @selected($grade === 'XII')>XII</option>
                </select>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Jurusan</label>
                <select name="major_id"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                               text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                    <option value="">Semua</option>
                    @foreach($majors as $m)
                        <option value="{{ $m->id }}" @selected((string)$majorId === (string)$m->id)>
                            {{ $m->code }} - {{ $m->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('classes.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
                Reset
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
                Filter
            </button>
        </div>
    </form>

    {{-- Table --}}
    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Kelas</th>
                        <th class="px-4 py-3 text-left font-semibold">Jurusan</th>
                        <th class="px-4 py-3 text-left font-semibold">Wali Kelas</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                    @forelse ($classes as $class)
                        <tr class="text-gray-700 dark:text-gray-100">
                            <td class="px-4 py-3 whitespace-nowrap font-medium">
                                {{ $class->grade_level }} {{ $class->major->code ?? '' }} {{ $class->rombel }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $class->major->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $class->homeroomTeacher->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <a href="{{ route('classes.edit', $class->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-white/10 hover:opacity-90 transition">
                                    Edit
                                </a>

                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Data kelas belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($classes, 'links'))
            <div class="px-4 py-3">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
