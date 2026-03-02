<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::query()->latest()->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        // NOTE: school_classes tidak punya kolom "name"
        // Kita urutkan berdasarkan tingkat, jurusan, rombel
        $classes = SchoolClass::query()
            ->with('major')
            ->orderByRaw("FIELD(grade_level, 'X', 'XI', 'XII')") // urut X, XI, XII
            ->orderBy('major_id')
            ->orderBy('rombel')
            ->get();

        return view('teachers.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],

            'is_active' => ['nullable', 'boolean'],

            // tabel yang benar: school_classes
            'homeroom_class_id' => ['nullable', 'exists:school_classes,id'], // exists rule [web:601]
        ]);

        return DB::transaction(function () use ($request, $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => $request->boolean('is_active'),
            ]);

            $user->assignRole('guru');

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            // Set wali kelas (kalau dipilih)
            if (!empty($data['homeroom_class_id'])) {
                SchoolClass::whereKey($data['homeroom_class_id'])->update([
                    'homeroom_teacher_id' => $teacher->id,
                ]);
            }

            return redirect()->route('teachers.index')
                ->with('success', 'Guru berhasil ditambahkan.');
        });
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $teacher->user_id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return DB::transaction(function () use ($request, $data, $teacher) {
            $teacher->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            if ($teacher->user_id) {
                $user = $teacher->user;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->is_active = $request->boolean('is_active');

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                $user->save();
            }

            return redirect()->route('teachers.index')
                ->with('success', 'Guru berhasil diupdate.');
        });
    }

    public function destroy(Teacher $teacher)
    {
        return DB::transaction(function () use ($teacher) {
            if ($teacher->user_id) {
                $teacher->user()->delete();
            }

            $teacher->delete();

            return back()->with('success', 'Guru berhasil dihapus.');
        });
    }
   public function kelasSaya(Request $request)
{
    $teacher = auth()->user()->teacher;  // Pastikan User hasOne Teacher
    $class = $teacher?->homeroomClass()->with(['major', 'students'])->first();
    
    $targetClasses = SchoolClass::with('major')
        ->when($class, function($q) use ($class) {
            return $q->where('grade_level', '>', $class->grade_level);
        })
        ->orderByRaw("FIELD(grade_level,'XI','XII')")
        ->orderBy('major_id')->orderBy('rombel')
        ->get();
    
    // POST: Naikkan kelas
    if ($request->isMethod('post') && $request->filled('to_class_id')) {
        $toClassId = $request->to_class_id;
        if ($class) {
            $class->students()->update(['current_class_id' => $toClassId]);
        }
        return back()->with('success', 'Siswa berhasil naik kelas!');
    }
    
    return view('guru.kelas-saya', compact('class', 'targetClasses'));
}


}
