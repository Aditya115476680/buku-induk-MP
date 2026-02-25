@extends('layouts.app')
@section('title', 'Tahun Ajaran')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Tahun Ajaran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola tahun ajaran & status aktif</p>
        </div>

        <a href="{{ route('academic-years.create') }}"
           class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
            + Tambah Tahun Ajaran
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
                        <th class="px-4 py-3 text-left font-semibold">Tahun</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                    @forelse ($years as $y)
                        <tr class="text-gray-700 dark:text-gray-100">
                            <td class="px-4 py-3 font-medium whitespace-nowrap">{{ $y->year }}</td>
                            <td class="px-4 py-3">
                                @if($y->is_active)
                                    <span class="px-2 py-1 rounded-md text-xs bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                {{-- Aktifkan (butuh route tambahan, lihat catatan bawah) --}}
                                <form action="{{ route('academic-years.activate', $y->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Jadikan tahun ajaran ini aktif?')">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition">
                                        Aktifkan
                                    </button>
                                </form>

                                <a href="{{ route('academic-years.edit', $y->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-white/10 hover:opacity-90 transition">
                                    Edit
                                </a>

                                <form action="{{ route('academic-years.destroy', $y->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus tahun ajaran ini?')">
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
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Data tahun ajaran belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
