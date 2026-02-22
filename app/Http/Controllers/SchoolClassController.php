<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $grade = $request->query('grade');    
        $majorId = $request->query('major_id'); 

        $classes = SchoolClass::query()
            ->with(['major', 'homeroomTeacher'])
            ->when($q, function ($query) use ($q) {
                $query->whereHas('major', function ($qMajor) use ($q) {
                    $qMajor->where('code', 'like', "%{$q}%")
                           ->orWhere('name', 'like', "%{$q}%");
                })->orWhere('rombel', 'like', "%{$q}%");
            })
            ->when($grade, fn($query) => $query->where('grade_level', $grade))
            ->when($majorId, fn($query) => $query->where('major_id', $majorId))
            ->orderByRaw("FIELD(grade_level,'X','XI','XII')")
            ->orderBy('major_id')
            ->orderBy('rombel')
            ->paginate(10)
            ->withQueryString();

        $majors = Major::query()->orderBy('code')->get();
        return view('classes.index', compact('classes', 'majors', 'q', 'grade', 'majorId'));
    }

    public function create()
    {
        $majors = Major::query()->orderBy('code')->get();
        $teachers = Teacher::query()->orderBy('name')->get();

        return view('classes.create', compact('majors', 'teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'grade_level' => ['required', Rule::in(['X', 'XI', 'XII'])],
            'major_id' => ['required', 'exists:majors,id'],
            'rombel' => ['required', 'integer', 'min:1', 'max:20'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]); 

        try {
            DB::transaction(function () use ($data) {
                SchoolClass::create([
                    'grade_level' => $data['grade_level'],
                    'major_id' => $data['major_id'],
                    'rombel' => $data['rombel'],
                    'homeroom_teacher_id' => $data['homeroom_teacher_id'] ?? null,
                ]);
            });
        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->withErrors(['grade_level' => 'Kelas tersebut sudah ada (tingkat + jurusan + rombel).']);
        }

        return redirect()
            ->route('classes.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $class)
    {
        $class->load(['major', 'homeroomTeacher']);

        $majors = Major::query()->orderBy('code')->get();
        $teachers = Teacher::query()->orderBy('name')->get();

        return view('classes.edit', compact('class', 'majors', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'grade_level' => ['required', Rule::in(['X', 'XI', 'XII'])],
            'major_id' => ['required', 'exists:majors,id'],
            'rombel' => ['required', 'integer', 'min:1', 'max:20'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        try {
            DB::transaction(function () use ($data, $class) {
                $class->update([
                    'grade_level' => $data['grade_level'],
                    'major_id' => $data['major_id'],
                    'rombel' => $data['rombel'],
                    'homeroom_teacher_id' => $data['homeroom_teacher_id'] ?? null,
                ]);
            });
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors(['grade_level' => 'Kelas tersebut sudah ada (tingkat + jurusan + rombel).']);
        }

        return redirect()
            ->route('classes.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(SchoolClass $class)
    {
        DB::transaction(function () use ($class) {
            $class->delete();
        });

        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    public function cetak($id)
    {

    $class = \App\Models\SchoolClass::with(
        'major',
        'homeroomTeacher'
    )->findOrFail($id);


    $students = \App\Models\Student::where(
        'current_class_id',
    $id
    )->get();


    return view('cetak.kelas',compact(
        'class',
        'students'
    ));

    }
}
