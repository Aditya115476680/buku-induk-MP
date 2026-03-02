@extends('layouts.app')
@section('title', 'Edit Guru')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Guru</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Update data guru</p>
        </div>

        <a href="{{ route('teachers.index') }}"
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

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST"
          class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                <input type="checkbox" name="is_active" value="1"
                    class="rounded border-gray-300 dark:border-white/10"
                    {{ old('is_active', $teacher->user?->is_active) ? 'checked' : '' }}>
                <span>Aktifkan akun guru (boleh login)</span>
            </label>
        </div>


            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                              text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">No HP (opsional)</label>
                <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                              text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Alamat (opsional)</label>
                <textarea name="address" rows="3"
                          class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                                 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">{{ old('address', $teacher->address) }}</textarea>
            </div>

            <div class="md:col-span-2 pt-2">
                <div class="text-sm font-semibold text-gray-800 dark:text-white">Ubah Password (opsional)</div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah password.</p>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Password Baru</label>
                <input type="password" name="password"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                              text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                       class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2
                              text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('teachers.index') }}"
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
