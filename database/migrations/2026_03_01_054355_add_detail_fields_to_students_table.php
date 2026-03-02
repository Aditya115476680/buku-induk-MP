<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // TEMPAT TINGGAL (kalau mau lebih detail dari address)
            $table->string('province')->nullable()->after('address');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
            $table->string('village')->nullable()->after('district');
            $table->string('postal_code', 10)->nullable()->after('village');

            // KESEHATAN
            $table->string('blood_type', 3)->nullable()->after('postal_code');
            $table->unsignedSmallInteger('height_cm')->nullable()->after('blood_type');
            $table->unsignedSmallInteger('weight_kg')->nullable()->after('height_cm');
            $table->text('medical_history')->nullable()->after('weight_kg');

            // PENDIDIKAN (sebelumnya/asal sekolah) - opsional
            $table->string('previous_school')->nullable()->after('medical_history');
            $table->year('entry_year')->nullable()->after('previous_school');

            // ORANG TUA
            $table->string('father_name')->nullable()->after('entry_year');
            $table->string('father_job')->nullable()->after('father_name');
            $table->string('father_phone', 20)->nullable()->after('father_job');
            $table->string('mother_name')->nullable()->after('father_phone');
            $table->string('mother_job')->nullable()->after('mother_name');
            $table->string('mother_phone', 20)->nullable()->after('mother_job');

            // WALI (kalau wali sudah ada, bisa skip atau tambah detail)
            $table->string('guardian_name')->nullable()->after('mother_phone');
            $table->string('guardian_phone', 20)->nullable()->after('guardian_name');
            $table->text('guardian_address')->nullable()->after('guardian_phone');

            // LAINNYA
            $table->string('art_hobby')->nullable()->after('guardian_address');
            $table->string('sport_hobby')->nullable()->after('art_hobby');
            $table->string('organization')->nullable()->after('sport_hobby');
            $table->boolean('has_scholarship')->nullable()->after('organization');
            $table->date('exit_date')->nullable()->after('has_scholarship');
            $table->string('exit_reason')->nullable()->after('exit_date');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'province','city','district','village','postal_code',
                'blood_type','height_cm','weight_kg','medical_history',
                'previous_school','entry_year',
                'father_name','father_job','father_phone',
                'mother_name','mother_job','mother_phone',
                'guardian_name','guardian_phone','guardian_address',
                'art_hobby','sport_hobby','organization',
                'has_scholarship','exit_date','exit_reason',
            ]);
        });
    }
};
