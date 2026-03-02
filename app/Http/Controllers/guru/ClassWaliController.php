<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassWaliController extends Controller
{
    public function show()
    {
        $teacherId = auth()->user()->teacher?->id;
        abort_if(!$teacherId, 403, 'Akun guru belum terhubung ke data Teacher.');

        $class = SchoolClass::query()
            ->with(['major', 'students'])
            ->where('homeroom_teacher_id', $teacherId)
            ->first();

        $targetClasses = collect();

        if ($class) {
            $nextGrade = match ($class->grade_level) {
                'X' => 'XI',
                'XI' => 'XII',
                default => null,
            };

            if ($nextGrade) {
                $targetClasses = SchoolClass::query()
                    ->with('major')
                    ->where('major_id', $class->major_id)
                    ->where('grade_level', $nextGrade)
                    ->orderBy('rombel')
                    ->get();
            }
        }

        return view('guru.kelas-saya', compact('class', 'targetClasses'));
    }

    public function promote(Request $request)
    {
        $teacherId = auth()->user()->teacher?->id;
        abort_if(!$teacherId, 403, 'Akun guru belum terhubung ke data Teacher.');

        $data = $request->validate([
            'to_class_id' => ['required', 'exists:school_classes,id'],
        ]);

        $currentClass = SchoolClass::query()
            ->where('homeroom_teacher_id', $teacherId)
            ->firstOrFail();

        abort_if((int) $data['to_class_id'] === (int) $currentClass->id, 422, 'Target kelas tidak boleh sama.');

        return DB::transaction(function () use ($currentClass, $data) {
            Student::query()
                ->where('school_class_id', $currentClass->id) // pastikan kolom ini ada di students
                ->update(['school_class_id' => $data['to_class_id']]);

            return back()->with('success', 'Siswa berhasil dinaikkan ke kelas target.');
        });
    }
}
