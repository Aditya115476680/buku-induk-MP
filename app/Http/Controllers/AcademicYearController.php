<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderByDesc('id')->get();
        return view('academic-years.index', compact('years'));
    }

    public function create()
    {
        return view('academic-years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => ['required', 'string', 'max:20'],
        ]);

        AcademicYear::create([
            'year' => $request->year,
            'is_active' => 0,
        ]);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $year = AcademicYear::findOrFail($id);
        return view('academic-years.edit', compact('year'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'year' => ['required', 'string', 'max:20'],
        ]);

        $year = AcademicYear::findOrFail($id);
        $year->update([
            'year' => $request->year,
        ]);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        AcademicYear::destroy($id);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function aktifkan($id)
    {
        AcademicYear::query()->update(['is_active' => 0]);
        AcademicYear::where('id', $id)->update(['is_active' => 1]);

        return back()->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
}
