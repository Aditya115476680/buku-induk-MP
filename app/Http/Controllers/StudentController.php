<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $q = $request->query('q');
        $classId = $request->query('class_id');
        $status = $request->query('status');

        $students = Student::query()
            ->with(['currentClass.major'])
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('nis', 'like', "%{$q}%")
                      ->orWhere('nisn', 'like', "%{$q}%");
            })
            ->when($classId, fn($query) => $query->where('current_class_id', $classId))
            ->when($status, function ($query) use ($status) {
                if ($status === 'aktif') $query->where('is_active', 1);
                if ($status === 'nonaktif') $query->where('is_active', 0);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $classes = SchoolClass::query()->with('major')
            ->orderByRaw("FIELD(grade_level,'X','XI','XII')")
            ->orderBy('major_id')
            ->orderBy('rombel')
            ->get();

        return view('admin.students.index', compact('students', 'classes', 'q', 'classId', 'status'));
    }

    public function create()
    {
        $classes = SchoolClass::query()->with('major')
            ->orderByRaw("FIELD(grade_level,'X','XI','XII')")
            ->orderBy('major_id')
            ->orderBy('rombel')
            ->get();

        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis'],
            'nisn' => ['required', 'string', 'max:50', 'unique:students,nisn'],
            'name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'current_class_id' => ['nullable', 'exists:school_classes,id'],
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        return DB::transaction(function () use ($data, $request) {
            $path = $request->file('photo')->store('students', 'public'); 
            $student = Student::create([
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'name' => $data['name'],
                'birth_place' => $data['birth_place'],
                'birth_date' => $data['birth_date'],
                'current_class_id' => $data['current_class_id'] ?? null,
                'photo_path' => $path,
                'is_active' => 1,
            ]);

            return redirect()
                ->route('admin.students.step.edit', ['student' => $student->id, 'step' => 2])
                ->with('success', 'Step 1 tersimpan. Lanjut isi data berikutnya.');
        });
    }

    public function editStep(Student $student, int $step)
    {
        abort_unless(in_array($step, [1,2,3,4], true), 404);

        $student->load(['currentClass.major', 'parent', 'history']);

        $classes = SchoolClass::query()->with('major')
            ->orderByRaw("FIELD(grade_level,'X','XI','XII')")
            ->orderBy('major_id')
            ->orderBy('rombel')
            ->get();

        return view('admin.students.steps.edit', compact('student', 'step', 'classes'));
    }

    public function updateStep(Request $request, Student $student, int $step)
    {
        abort_unless(in_array($step, [1,2,3,4], true), 404);

        if ($step === 1) {
            return $this->updateStep1($request, $student);
        }

        if ($step === 2) {
            return $this->updateStep2($request, $student);
        }

        if ($step === 3) {
            return $this->updateStep3($request, $student);
        }

        return $this->updateStep4($request, $student);
    }

    private function updateStep1(Request $request, Student $student)
    {
        $data = $request->validate([
            'nis' => ['required', 'string', 'max:50', Rule::unique('students', 'nis')->ignore($student->id)],
            'nisn' => ['required', 'string', 'max:50', Rule::unique('students', 'nisn')->ignore($student->id)],
            'name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'current_class_id' => ['nullable', 'exists:school_classes,id'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        return DB::transaction(function () use ($data, $request, $student) {
            $payload = [
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'name' => $data['name'],
                'birth_place' => $data['birth_place'],
                'birth_date' => $data['birth_date'],
                'current_class_id' => $data['current_class_id'] ?? null,
            ];

            if ($request->hasFile('photo')) {
                if ($student->photo_path) {
                    Storage::disk('public')->delete($student->photo_path); // delete file [web:75]
                }
                $payload['photo_path'] = $request->file('photo')->store('students', 'public'); // store [web:75]
            }

            $student->update($payload);

            return redirect()
                ->route('admin.students.step.edit', ['student' => $student->id, 'step' => 2])
                ->with('success', 'Step 1 diupdate.');
        });
    }

    private function updateStep2(Request $request, Student $student)
    {
        $data = $request->validate([
            'address' => ['nullable', 'string'],
        ]);

        $student->update([
            'address' => $data['address'] ?? null,
        ]);

        return redirect()
            ->route('admin.students.step.edit', ['student' => $student->id, 'step' => 3])
            ->with('success', 'Step 2 tersimpan.');
    }

    private function updateStep3(Request $request, Student $student)
    {
        $data = $request->validate([
            'father_name' => ['nullable', 'string', 'max:255'],
            'father_phone' => ['nullable', 'string', 'max:50'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'mother_phone' => ['nullable', 'string', 'max:50'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:50'],
            'parents_address' => ['nullable', 'string'],
        ]);

        $student->parent()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'father_name' => $data['father_name'] ?? null,
                'father_phone' => $data['father_phone'] ?? null,
                'mother_name' => $data['mother_name'] ?? null,
                'mother_phone' => $data['mother_phone'] ?? null,
                'guardian_name' => $data['guardian_name'] ?? null,
                'guardian_phone' => $data['guardian_phone'] ?? null,
                'address' => $data['parents_address'] ?? null,
            ]
        );

        return redirect()
            ->route('admin.students.step.edit', ['student' => $student->id, 'step' => 4])
            ->with('success', 'Step 3 tersimpan.');
    }

    private function updateStep4(Request $request, Student $student)
    {
        $data = $request->validate([
            'previous_school' => ['nullable', 'string', 'max:255'],
            'entry_year' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'notes' => ['nullable', 'string'],
        ]);

        $student->history()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'previous_school' => $data['previous_school'] ?? null,
                'entry_year' => $data['entry_year'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]
        );

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa lengkap tersimpan.');
    }


    public function edit(Student $student)
    {
        return redirect()->route('admin.students.step.edit', ['student' => $student->id, 'step' => 1]);
    }

    public function update(Request $request, Student $student)
    {
        abort(404);
    }

    public function destroy(Student $student)
    {
        return DB::transaction(function () use ($student) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }

            $student->delete();

            return back()->with('success', 'Siswa berhasil dihapus.');
        });
    }
}
