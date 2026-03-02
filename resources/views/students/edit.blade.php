@extends('layouts.app')
@section('title', 'Edit Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Siswa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student->name }}</p>
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

    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data"
          class="rounded-xl bg-white dark:bg-brandCard shadow-sm border border-gray-100 dark:border-white/10 p-5 space-y-5"
          x-data="{ tab: 'data_diri' }">
        @csrf
        @method('PATCH')

        {{-- Tabs --}}
        <div class="flex flex-wrap gap-2 border-b border-gray-200 dark:border-white/10 pb-3">
            @php
                $tabs = [
                    'data_diri' => 'Data Diri',
                    'tempat_tinggal' => 'Tempat Tinggal',
                    'kesehatan' => 'Kesehatan',
                    'pendidikan' => 'Pendidikan',
                    'orang_tua' => 'Orang Tua',
                    'wali' => 'Wali',
                    'lainnya' => 'Lainnya',
                ];
            @endphp

            @foreach($tabs as $key => $label)
                <button type="button"
                        @click="tab='{{ $key }}'"
                        :class="tab==='{{ $key }}' ? 'bg-brandAccent text-white' : 'bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white'"
                        class="px-3 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- DATA DIRI --}}
        <div x-show="tab==='data_diri'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $student->nis) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', $student->nisn) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tanggal Lahir</label>
                    <input type="date" name="birth_date"
                           value="{{ old('birth_date', optional($student->birth_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kelas (opsional)</label>
                    <select name="current_class_id"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                        <option value="">- Pilih Kelas -</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}"
                                @selected(old('current_class_id', $student->current_class_id) == $c->id)>
                                {{ $c->grade_level }} {{ $c->major->name ?? '' }} {{ $c->rombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Foto (opsional)</label>
                    <input type="file" name="photo" accept="image/*"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                    @if($student->photo_path)
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Foto sudah ada, upload baru untuk mengganti.
                        </p>
                    @endif
                </div>

                <div class="md:col-span-2 flex items-center gap-2">
                    <input id="is_active" type="checkbox" name="is_active" value="1"
                           @checked(old('is_active', (bool)$student->is_active))
                           class="rounded border-gray-300">
                    <label for="is_active" class="text-sm text-gray-700 dark:text-gray-200">Status aktif</label>
                </div>
            </div>
        </div>

        {{-- TEMPAT TINGGAL --}}
        <div x-show="tab==='tempat_tinggal'" class="space-y-4">
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">{{ old('address', $student->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $student->province) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kota/Kab</label>
                    <input type="text" name="city" value="{{ old('city', $student->city) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kecamatan</label>
                    <input type="text" name="district" value="{{ old('district', $student->district) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Desa/Kel</label>
                    <input type="text" name="village" value="{{ old('village', $student->village) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $student->postal_code) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
            </div>
        </div>

        {{-- KESEHATAN --}}
        <div x-show="tab==='kesehatan'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Gol. darah</label>
                    <input type="text" name="blood_type" value="{{ old('blood_type', $student->blood_type) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tinggi (cm)</label>
                    <input type="number" name="height_cm" value="{{ old('height_cm', $student->height_cm) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Berat (kg)</label>
                    <input type="number" name="weight_kg" value="{{ old('weight_kg', $student->weight_kg) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Riwayat penyakit</label>
                <textarea name="medical_history" rows="3"
                          class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">{{ old('medical_history', $student->medical_history) }}</textarea>
            </div>
        </div>

        {{-- PENDIDIKAN --}}
        <div x-show="tab==='pendidikan'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Asal sekolah</label>
                    <input type="text" name="previous_school" value="{{ old('previous_school', $student->previous_school) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tahun masuk</label>
                    <input type="number" name="entry_year" value="{{ old('entry_year', $student->entry_year) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
            </div>
        </div>

        {{-- ORANG TUA --}}
        <div x-show="tab==='orang_tua'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama Ayah</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Pekerjaan Ayah</label>
                    <input type="text" name="father_job" value="{{ old('father_job', $student->father_job) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">No HP Ayah</label>
                    <input type="text" name="father_phone" value="{{ old('father_phone', $student->father_phone) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama Ibu</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Pekerjaan Ibu</label>
                    <input type="text" name="mother_job" value="{{ old('mother_job', $student->mother_job) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">No HP Ibu</label>
                    <input type="text" name="mother_phone" value="{{ old('mother_phone', $student->mother_phone) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
            </div>
        </div>

        {{-- WALI --}}
        <div x-show="tab==='wali'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama Wali</label>
                    <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">No HP Wali</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Alamat Wali</label>
                    <textarea name="guardian_address" rows="3"
                              class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">{{ old('guardian_address', $student->guardian_address) }}</textarea>
                </div>
            </div>
        </div>

        {{-- LAINNYA --}}
        <div x-show="tab==='lainnya'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kesenian</label>
                    <input type="text" name="art_hobby" value="{{ old('art_hobby', $student->art_hobby) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Olahraga</label>
                    <input type="text" name="sport_hobby" value="{{ old('sport_hobby', $student->sport_hobby) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Organisasi</label>
                    <input type="text" name="organization" value="{{ old('organization', $student->organization) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>

                <div class="md:col-span-2 flex items-center gap-2">
                    <input id="has_scholarship" type="checkbox" name="has_scholarship" value="1"
                           @checked(old('has_scholarship', (bool)$student->has_scholarship))
                           class="rounded border-gray-300">
                    <label for="has_scholarship" class="text-sm text-gray-700 dark:text-gray-200">Menerima beasiswa</label>
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Tanggal keluar</label>
                    <input type="date" name="exit_date"
                           value="{{ old('exit_date', optional($student->exit_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Alasan keluar</label>
                    <input type="text" name="exit_reason" value="{{ old('exit_reason', $student->exit_reason) }}"
                           class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brandAccent/40">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2">
            <a href="{{ route('students.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:opacity-90 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg bg-brandAccent text-white hover:opacity-90 transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
