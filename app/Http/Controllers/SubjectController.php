<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Major;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function index()
    {
        $subjects = Subject::with('major')->get();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $majors = Major::all();

        return view('subjects.create', compact('majors'));
    }

    public function store(Request $request)
    {
        Subject::create([
            'name' => $request->name,
            'major_id' => $request->major_id,
            'type' => $request->type
        ]);

        return redirect()->route('subjects.index');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $majors = Major::all();

        return view('subjects.edit',
            compact('subject','majors'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $subject->update([
            'name'=>$request->name,
            'major_id'=>$request->major_id,
            'type'=>$request->type
        ]);

        return redirect()->route('subjects.index');
    }

    public function destroy($id)
    {
        Subject::destroy($id);

        return back();
    }

}