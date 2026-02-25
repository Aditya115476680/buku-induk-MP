<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Major;
use App\Models\Subject;
use App\Models\Grade;

class DashboardController extends Controller
{
    public function index()
{
    return view('dashboard.index', [
        'jumlahSiswa' => Student::count(),
        'jumlahKelas' => SchoolClass::count(),
        'jumlahMapel' => Subject::count(),
        'jumlahNilai' => Grade::count(),
        'rataNilai' => Grade::avg('score') ?? 0,
    ]);
}
}