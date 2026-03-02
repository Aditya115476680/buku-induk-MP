<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
        $table->id();
        $table->enum('grade_level', ['X', 'XI', 'XII']);
        $table->unsignedTinyInteger('rombel')->default(1);

        $table->foreignId('major_id')->constrained()->restrictOnDelete();

        // wali kelas boleh kosong
        $table->foreignId('homeroom_teacher_id')
            ->nullable()
            ->constrained('teachers')   // pastikan refer ke tabel teachers
            ->nullOnDelete();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
