@extends('layouts.app')
@section('title', 'Mata Pelajaran')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Mata Pelajaran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola mapel per jurusan & tipe</p>
        </div>

        <a href="{{ route('subjects.create') }}"
           class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
            + Tambah Mapel
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200 p-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nama Mapel</th>
                        <th class="px-4 py-3 text-left font-semibold">Jurusan</th>
                        <th class="px-4 py-3 text-left font-semibold">Tipe</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                    @forelse($subjects as $s)
                        <tr class="text-gray-700 dark:text-gray-100">
                            <td class="px-4 py-3 font-medium">{{ $s->name }}</td>
                            <td class="px-4 py-3">{{ $s->major->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300">
                                    {{ $s->type ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('subjects.edit', $s->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-white/10 hover:opacity-90 transition">
                                    Edit
                                </a>

                                <form action="{{ route('subjects.destroy', $s->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus mapel ini?')">
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
                                Data mapel belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
