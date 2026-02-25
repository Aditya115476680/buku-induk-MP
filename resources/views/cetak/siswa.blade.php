@extends('layouts.app')
@section('title', 'Cetak Data Siswa')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Cetak Data Siswa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tampilan siap print</p>
        </div>

        <button onclick="window.print()"
                class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
            Print
        </button>
    </div>

    <div class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5">
        <div class="text-center mb-4">
            <div class="font-semibold text-gray-800 dark:text-white">DAFTAR DATA SISWA</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ date('d-m-Y') }}</div>
        </div>

        @php
            $rows = $students ?? collect();
        @endphp

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold w-12">No</th>
                        <th class="px-3 py-2 text-left font-semibold">NIS</th>
                        <th class="px-3 py-2 text-left font-semibold">NISN</th>
                        <th class="px-3 py-2 text-left font-semibold">Nama</th>
                        <th class="px-3 py-2 text-left font-semibold">Kelas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                    @forelse($rows as $i => $s)
                        <tr class="text-gray-800 dark:text-gray-100">
                            <td class="px-3 py-2">{{ $i + 1 }}</td>
                            <td class="px-3 py-2">{{ $s->nis ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $s->nisn ?? '-' }}</td>
                            <td class="px-3 py-2 font-medium">{{ $s->name ?? '-' }}</td>
                            <td class="px-3 py-2">
                                @if(isset($s->currentClass))
                                    {{ $s->currentClass->grade_level }} {{ $s->currentClass->major->code ?? '' }} {{ $s->currentClass->rombel }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-gray-500 dark:text-gray-400">
                                Data belum dikirim ke view. (Saat ini route kamu masih langsung return view tanpa query siswa.)
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CSS khusus print --}}
<style>
@media print {
    nav, aside, header, .no-print { display: none !important; }
    body { background: white !important; }
}
</style>
@endsection
