<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{

    public function index()
    {
        $years = AcademicYear::all();

        return view('academic_year.index', compact('years'));
    }


    public function create()
    {
        return view('academic_year.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required'
        ]);

        AcademicYear::create([
            'year' => $request->year,
            'is_active' => 0
        ]);

        return redirect()->route('academic-year.index');
    }


    public function edit($id)
    {
        $year = AcademicYear::findOrFail($id);

        return view('academic_year.edit', compact('year'));
    }


    public function update(Request $request, $id)
    {
        $year = AcademicYear::findOrFail($id);

        $year->update([
            'year' => $request->year
        ]);

        return redirect()->route('academic-year.index');
    }


    public function destroy($id)
    {
        AcademicYear::destroy($id);

        return redirect()->route('academic-year.index');
    }


    public function aktifkan($id)
    {
        AcademicYear::query()->update([
            'is_active' => 0
        ]);

        AcademicYear::where('id',$id)->update([
            'is_active' => 1
        ]);

        return back();
    }

}