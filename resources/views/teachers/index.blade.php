@extends('layouts.app')
@section('title', 'Data Guru')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Data Guru</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data guru</p>
        </div>

        <a href="{{ route('teachers.create') }}"
           class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
            + Tambah Guru
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
                        <th class="px-4 py-3 text-left font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold">Email</th>
                        <th class="px-4 py-3 text-left font-semibold">No HP</th>
                        <th class="px-4 py-3 text-left font-semibold">Alamat</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                    @forelse ($teachers as $teacher)
                        <tr class="text-gray-700 dark:text-gray-100">
                            <td class="px-4 py-3 whitespace-nowrap font-medium">{{ $teacher->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->phone ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $teacher->address ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <a href="{{ route('teachers.edit', $teacher->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-white/10 hover:opacity-90 transition">
                                    Edit
                                </a>

                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus guru ini? Akun user juga akan terhapus.')">
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
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Data guru belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($teachers, 'links'))
            <div class="px-4 py-3">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
