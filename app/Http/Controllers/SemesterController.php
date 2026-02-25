<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('academicYear')
            ->orderByDesc('id')
            ->get();

        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        $years = AcademicYear::orderByDesc('id')->get();
        return view('semesters.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => ['required'],
            'name' => ['required', 'string', 'max:50'],
        ]);

        Semester::create([
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semester berhasil ditambah');
    }

    public function edit(Semester $semester)
    {
        $years = AcademicYear::orderByDesc('id')->get();
        return view('semesters.edit', compact('semester', 'years'));
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'academic_year_id' => ['required'],
            'name' => ['required', 'string', 'max:50'],
        ]);

        $semester->update([
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semester berhasil diupdate');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semester berhasil dihapus');
    }
}
