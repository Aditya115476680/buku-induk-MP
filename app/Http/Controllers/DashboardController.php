<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;

class DashboardController extends Controller
{
    public function index()
{
    return view('dashboard.index', [
        'totalStudents' => \App\Models\Student::count(),
        'totalTeachers' => \App\Models\Teacher::count(),
        'totalClasses'  => \App\Models\SchoolClass::count(),
        'totalMajors'   => \App\Models\Major::count(),
    ]);
}

}
