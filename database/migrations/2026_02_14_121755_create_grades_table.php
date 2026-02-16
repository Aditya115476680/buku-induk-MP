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
        Schema::create('grades', function (Blueprint $table) {
    $table->id();
    $table->decimal('score', 5, 2);    
    $table->unsignedSmallInteger('kkm')->default(75);
    $table->unique(['student_id','semester_id','subject_id'], 'uniq_grade_student_semester_subject');

    $table->foreignId('student_id')->constrained()->cascadeOnDelete();
    $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
