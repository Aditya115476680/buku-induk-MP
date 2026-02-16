<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Iluminate\Support\Facades\DB;
use Iluminate\Support\Facades\Hash;
use App\models\Teacher;
use App\models\User;


class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::query()->latest()->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view ('teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullablr', 'string'],
        ]);

        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole('guru');

            Teacher::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            return redirect()->route('teachers.index')
                ->with('success', 'Guru berhasil ditambahkan.');
        });
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $teacher->user_id],
            'phone' => ['nullable','string','max:30'],
            'address' => ['nullable','string'],
            'password' => ['nullable','confirmed','min:8'],
        ]);

        return DB::transaction(function () use ($data, $teacher) {
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
            // hapus user juga biar akun login hilang
            if ($teacher->user_id) {
                $teacher->user()->delete();
            }
            $teacher->delete();

            return back()->with('success', 'Guru berhasil dihapus.');
        });
    }
}
