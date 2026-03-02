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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('guru')) {
        return redirect()->route('guru.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin|guru'])->group(function () {
    Route::get('/cetak/buku-induk', function () {
        return view('cetak.buku');
    })->name('cetak.buku');

    Route::get('/cetak/data-siswa', function () {
        return view('cetak.siswa');
    })->name('cetak.siswa');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/academic-years/{id}/activate', [AcademicYearController::class, 'aktifkan'])
        ->name('academic-years.activate');

   Route::resource('students', StudentController::class);
Route::get('/students/{id}/grades', [StudentController::class, 'grades'])->name('student.grades');
Route::get('/cetak/buku/{id}', [StudentController::class, 'cetakBuku'])->name('cetak.bukuInduk');


    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', SchoolClassController::class);
    Route::resource('majors', MajorController::class);

    Route::resource('academic-years', AcademicYearController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('subjects', SubjectController::class);

    Route::resource('grades', GradeController::class);
    Route::get('/input-nilai', [GradeController::class, 'inputNilai'])->name('grades.filter');
    Route::post('/show-students', [GradeController::class, 'showStudents'])->name('grades.showStudents');
    Route::post('/store-bulk', [GradeController::class, 'storeBulk'])->name('grades.storeBulk');
});

Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', function() { return view('guru.dashboard'); })->name('dashboard');
        
        // PROMOTE POST (HARUS SEBELUM GET)
        Route::post('/kelas-saya/promote', [TeacherController::class, 'kelasSaya'])->name('kelas-saya.promote');
        
        // GET Kelas Saya (LAYOUT DEPEND ON THIS)
        Route::get('/kelas-saya', [TeacherController::class, 'kelasSaya'])->name('kelas-saya');
        
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/', fn() => view('guru.nilai.index'))->name('index');
            Route::get('/rekap', fn() => view('guru.nilai.rekap'))->name('rekap');
        });
        
        Route::prefix('cetak')->name('cetak.')->group(function () {
            Route::get('/rapor', fn() => view('guru.cetak.rapor'))->name('rapor');
        });
    });


require __DIR__.'/auth.php';
