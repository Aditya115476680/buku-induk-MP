@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Data Siswa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total: {{ $students->total() }} siswa
            </p>
        </div>

        <a href="{{ route('students.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg
                  bg-brandAccent text-white hover:opacity-90 transition">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Siswa</span>
        </a>
    </div>

    {{-- Filter --}}
    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
        <form method="GET" action="{{ route('students.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-5">
                    <label class="block text-xs mb-1 text-gray-500 dark:text-gray-400">Cari</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/NIS/NISN"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white
                                  outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs mb-1 text-gray-500 dark:text-gray-400">Kelas</label>
                    <select name="class_id"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10
                                   bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white
                                   outline-none focus:ring-2 focus:ring-brandAccent/40">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected((string)request('class_id') === (string)$class->id)>
                                {{ $class->grade_level }} {{ $class->major->name ?? '-' }} {{ $class->rombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs mb-1 text-gray-500 dark:text-gray-400">Status</label>
                    <select name="status"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10
                                   bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white
                                   outline-none focus:ring-2 focus:ring-brandAccent/40">
                        <option value="">Semua</option>
                        <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>

                <div class="md:col-span-2 flex items-end gap-2">
                    <button type="submit"
                            class="w-full px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
                        Cari
                    </button>
                    <a href="{{ route('students.index') }}"
                       class="w-full px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10
                              text-gray-800 dark:text-white hover:opacity-90 transition text-center">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr class="text-left text-gray-600 dark:text-gray-200">
                        <th class="px-5 py-3 font-semibold">Nama</th>
                        <th class="px-5 py-3 font-semibold">NIS</th>
                        <th class="px-5 py-3 font-semibold">NISN</th>
                        <th class="px-5 py-3 font-semibold">Kelas</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="px-5 py-4 font-medium text-gray-800 dark:text-white">
                                {{ $student->name }}
                            </td>
                            <td class="px-5 py-4 text-gray-700 dark:text-gray-200">
                                {{ $student->nis }}
                            </td>
                            <td class="px-5 py-4 text-gray-700 dark:text-gray-200">
                                {{ $student->nisn }}
                            </td>
                            <td class="px-5 py-4 text-gray-700 dark:text-gray-200">
                                @if($student->currentClass)
                                    {{ $student->currentClass->grade_level }}
                                    {{ $student->currentClass->major->name ?? '-' }}
                                    {{ $student->currentClass->rombel }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $student->is_active
                                        ? 'bg-green-100 text-green-800 dark:bg-green-500/15 dark:text-green-200'
                                        : 'bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-200' }}">
                                    {{ $student->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('student.grades', $student->id) }}"
                                       class="text-blue-600 dark:text-blue-300 hover:underline">
                                        Nilai
                                    </a>

                                    <a href="{{ route('cetak.bukuInduk', $student->id) }}"
                                       class="text-green-600 dark:text-green-300 hover:underline">
                                        Cetak
                                    </a>

                                    <form method="POST" action="{{ route('students.destroy', $student) }}"
                                          class="inline"
                                          onsubmit="return confirm('Hapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 dark:text-red-300 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data siswa.
                                <a href="{{ route('students.create') }}"
                                   class="text-brandAccent hover:underline font-semibold">
                                    Tambah sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 bg-gray-50 dark:bg-white/5">
            {{ $students->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
