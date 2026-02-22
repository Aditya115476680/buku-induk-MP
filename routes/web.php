<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth'])
->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::middleware('auth')->group(function () {

    Route::resource('students', StudentController::class);

    Route::get('/students/{id}/grades',[StudentController::class,'grades'])->name('student.grades');
    Route::get('/cetak/buku/{id}',[StudentController::class,'cetakBuku'])->name('cetak.bukuInduk');

    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', SchoolClassController::class);
    Route::resource('majors', MajorController::class);

    Route::resource('academic-years', AcademicYearController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('subjects', SubjectController::class);

    Route::resource('grades', GradeController::class);

    Route::get('/input-nilai',[GradeController::class,'inputNilai'])->name('grades.filter');
    Route::post('/show-students',[GradeController::class,'showStudents'])->name('grades.showStudents');
    Route::post('/store-bulk',[GradeController::class,'storeBulk'])->name('grades.storeBulk');

});

Route::get('/cetak/buku-induk', function () {
    return view('cetak.buku');
})->name('cetak.buku');


Route::get('/cetak/data-siswa', function () {
    return view('cetak.siswa');
})->name('cetak.siswa');


require __DIR__.'/auth.php';