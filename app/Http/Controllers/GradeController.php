<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class GradeController extends Controller
{

    public function index()
    {

        $grades = Grade::with(
            'student',
            'subject',
            'academicYear',
            'semester'
        )->latest()->get();

        return view('grades.index', compact('grades'));

    }


    public function create()
    {

        $students = Student::all();
        $subjects = Subject::all();
        $years = AcademicYear::all();
        $semesters = Semester::all();

        return view('grades.create', compact(
            'students',
            'subjects',
            'years',
            'semesters'
        ));

    }


    public function store(Request $request)
    {

        $request->validate([
            'student_id'=>'required',
            'subject_id'=>'required',
            'academic_year_id'=>'required',
            'semester_id'=>'required',
            'score'=>'required|numeric'
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')
        ->with('success','Nilai berhasil disimpan');

    }

    public function inputNilai()
    {

        $classes = \App\Models\SchoolClass::all();
        $years = \App\Models\AcademicYear::all();
        $semesters = \App\Models\Semester::all();
        $subjects = \App\Models\Subject::all();

        return view('grades.filter', compact(
            'classes',
            'years',
            'semesters',
            'subjects'
        ));

    }

    public function showStudents(Request $request)
    {

        $students = \App\Models\Student::where(
            'current_class_id',
            $request->class_id
        )->get();


        $subject_id = $request->subject_id;
        $year_id = $request->year_id;
        $semester_id = $request->semester_id;


        foreach($students as $student){

            $grade = \App\Models\Grade::where('student_id',$student->id)
            ->where('subject_id',$subject_id)
            ->where('academic_year_id',$year_id)
            ->where('semester_id',$semester_id)
            ->first();

            $student->score = $grade->score ?? '';

        }


        return view('grades.input', compact(
            'students',
            'subject_id',
            'year_id',
            'semester_id'
        ));

    }

    public function storeBulk(Request $request)
    {

    foreach($request->scores as $student_id => $score){

    \App\Models\Grade::updateOrCreate(

    [
       'student_id'=>$student_id,
        'subject_id'=>$request->subject_id,
        'academic_year_id'=>$request->year_id,
        'semester_id'=>$request->semester_id
    ],

    [
        'score'=>$score 
    ]

    );

    }

        return redirect()->route('grades.filter')
        ->with('success','Nilai berhasil disimpan');

    }


}