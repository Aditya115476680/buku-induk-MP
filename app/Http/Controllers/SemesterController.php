<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class SemesterController extends Controller
{

    public function index()
    {
        $semesters = Semester::with('academicYear')->get();

        return view('semester.index', compact('semesters'));
    }


    public function create()
    {
        $years = AcademicYear::all();

        return view('semester.create', compact('years'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required',
            'name' => 'required'
        ]);

        Semester::create($request->all());

        return redirect()->route('semester.index')
            ->with('success','Semester berhasil ditambah');
    }


    public function edit(Semester $semester)
    {
        $years = AcademicYear::all();

        return view('semester.edit', compact('semester','years'));
    }


    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'academic_year_id' => 'required',
            'name' => 'required'
        ]);

        $semester->update($request->all());

        return redirect()->route('semester.index')
            ->with('success','Semester berhasil diupdate');
    }


    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('semester.index');
    }

}