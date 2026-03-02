<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::orderBy('grade_level')
            ->orderBy('rombel')
            ->get();

        $studentsQuery = Student::with('currentClass.major');

        if ($q = $request->q) {
            $studentsQuery->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                ->orWhere('nis', 'like', "%{$q}%")
                ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        if ($request->filled('class_id')) {
            $studentsQuery->where('current_class_id', $request->class_id);
        }

        if ($request->status === 'aktif') {
            $studentsQuery->where('is_active', true);
        } elseif ($request->status === 'nonaktif') {
            $studentsQuery->where('is_active', false);
        }

        $students = $studentsQuery->latest()->paginate(10);

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('grade_level')
        ->orderBy('rombel')
        ->get();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required','string','max:50', 'unique:students,nis'],
            'nisn' => ['required','string','max:50', 'unique:students,nisn'],
            'name' => ['required','string','max:255'],
            'birth_place' => ['required','string','max:255'],
            'birth_date' => ['required','date'],
            'current_class_id' => ['nullable','exists:school_classes,id'],
            'is_active' => ['nullable','boolean'],
            'address' => ['nullable','string'],

            // Upload foto (jpg/png maks 2MB)
            'photo' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],

            // Tambahan sesuai tab
            'province' => ['nullable','string','max:100'],
            'city' => ['nullable','string','max:100'],
            'district' => ['nullable','string','max:100'],
            'village' => ['nullable','string','max:100'],
            'postal_code' => ['nullable','string','max:10'],

            'blood_type' => ['nullable','string','max:3'],
            'height_cm' => ['nullable','integer','min:0'],
            'weight_kg' => ['nullable','integer','min:0'],
            'medical_history' => ['nullable','string'],

            'previous_school' => ['nullable','string','max:255'],
            'entry_year' => ['nullable','integer','min:1900','max:2100'],

            'father_name' => ['nullable','string','max:255'],
            'father_job' => ['nullable','string','max:255'],
            'father_phone' => ['nullable','string','max:20'],
            'mother_name' => ['nullable','string','max:255'],
            'mother_job' => ['nullable','string','max:255'],
            'mother_phone' => ['nullable','string','max:20'],

            'guardian_name' => ['nullable','string','max:255'],
            'guardian_phone' => ['nullable','string','max:20'],
            'guardian_address' => ['nullable','string'],

            'art_hobby' => ['nullable','string','max:255'],
            'sport_hobby' => ['nullable','string','max:255'],
            'organization' => ['nullable','string','max:255'],
            'has_scholarship' => ['nullable','boolean'],
            'exit_date' => ['nullable','date'],
            'exit_reason' => ['nullable','string','max:255'],
        ]);

        // Normalisasi checkbox yang tidak dicentang (tidak terkirim)
        $validated['is_active'] = $request->boolean('is_active');
        $validated['has_scholarship'] = $request->boolean('has_scholarship');

        // Upload foto
        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('students', 'public');
        }

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        $student->load('currentClass');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nis' => ['required','string','max:50', Rule::unique('students', 'nis')->ignore($student->id)],
            'nisn' => ['required','string','max:50', Rule::unique('students', 'nisn')->ignore($student->id)],
            'name' => ['required','string','max:255'],
            'birth_place' => ['required','string','max:255'],
            'birth_date' => ['required','date'],
            'current_class_id' => ['nullable','exists:school_classes,id'],
            'is_active' => ['nullable','boolean'],
            'address' => ['nullable','string'],

            'photo' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],

            'province' => ['nullable','string','max:100'],
            'city' => ['nullable','string','max:100'],
            'district' => ['nullable','string','max:100'],
            'village' => ['nullable','string','max:100'],
            'postal_code' => ['nullable','string','max:10'],

            'blood_type' => ['nullable','string','max:3'],
            'height_cm' => ['nullable','integer','min:0'],
            'weight_kg' => ['nullable','integer','min:0'],
            'medical_history' => ['nullable','string'],

            'previous_school' => ['nullable','string','max:255'],
            'entry_year' => ['nullable','integer','min:1900','max:2100'],

            'father_name' => ['nullable','string','max:255'],
            'father_job' => ['nullable','string','max:255'],
            'father_phone' => ['nullable','string','max:20'],
            'mother_name' => ['nullable','string','max:255'],
            'mother_job' => ['nullable','string','max:255'],
            'mother_phone' => ['nullable','string','max:20'],

            'guardian_name' => ['nullable','string','max:255'],
            'guardian_phone' => ['nullable','string','max:20'],
            'guardian_address' => ['nullable','string'],

            'art_hobby' => ['nullable','string','max:255'],
            'sport_hobby' => ['nullable','string','max:255'],
            'organization' => ['nullable','string','max:255'],
            'has_scholarship' => ['nullable','boolean'],
            'exit_date' => ['nullable','date'],
            'exit_reason' => ['nullable','string','max:255'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['has_scholarship'] = $request->boolean('has_scholarship');

        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
