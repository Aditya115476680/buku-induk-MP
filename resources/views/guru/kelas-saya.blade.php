@extends('layouts.guru')
@section('title', 'Kelas Saya (Wali)')

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Kelas Saya (Wali)</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Lihat siswa & naikkan kelas.</p>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 text-green-800 dark:border-green-500/30 dark:bg-green-500/10 dark:text-red-200 p-4">
            {{ session('success') }}
        </div>
    @endif

    @if (!$class)
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            Kamu belum ditetapkan sebagai wali kelas.
        </div>
    @else
        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">Kelas wali</div>
            <div class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ $class->grade_level }} {{ $class->major->name ?? '-' }} {{ $class->rombel }}
            </div>
        </div>

        <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">Daftar siswa</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Total: {{ $class->students->count() }} siswa
                    </div>
                </div>

                <form method="POST" action="{{ route('guru.kelas-saya.promote') }}" class="flex items-center gap-2">
                    @csrf
                    <select name="to_class_id"
                            class="rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                                   text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40"
                            required>
                        <option value="">-- Pilih kelas target --</option>
                        @foreach($targetClasses as $c)
                            <option value="{{ $c->id }}">
                                {{ $c->grade_level }} {{ $c->major->name ?? '-' }} {{ $c->rombel }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition"
                            onclick="return confirm('Yakin naikkan semua siswa ke kelas target?')">
                        Naikkan kelas
                    </button>
                </form>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-300">
                            <th class="py-2 pr-4">No</th>
                            <th class="py-2 pr-4">Nama</th>
                            <th class="py-2 pr-4">NISN</th>
                            <th class="py-2 pr-4">NIS</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-white">
                        @forelse ($class->students as $i => $siswa)
                            <tr class="border-t border-gray-100 dark:border-white/10">
                                <td class="py-2 pr-4">{{ $i + 1 }}</td>
                                <td class="py-2 pr-4">{{ $siswa->name ?? $siswa->nama ?? '-' }}</td>
                                <td class="py-2 pr-4">{{ $siswa->nisn ?? '-' }}</td>
                                <td class="py-2 pr-4">{{ $siswa->nis ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr class="border-t border-gray-100 dark:border-white/10">
                                <td class="py-3 text-gray-500 dark:text-gray-300" colspan="4">
                                    Belum ada siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
