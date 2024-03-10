<?php

use App\Http\Controllers\Admin\AsesmentController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\IndikatorController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\NilaiMhsController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\AsesmentDosenController;
use App\Http\Controllers\Dosen\JurnalShowController;
use App\Http\Controllers\Dosen\NilaiController;
use App\Http\Controllers\Dosen\ReportShowController;
use App\Http\Controllers\Dosen\SeminarShowController;
use App\Http\Controllers\Mahasiswa\AsesmentShowController;
use App\Http\Controllers\Mahasiswa\JurnalController;
use App\Http\Controllers\Mahasiswa\LoogBookController;
use App\Http\Controllers\Mahasiswa\MatkulMhsController;
use App\Http\Controllers\Mahasiswa\ReportController;
use App\Http\Controllers\Mahasiswa\SeminarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);

Route::group(['middleware' => ['auth', 'role:Admin']], function() {
    Route::prefix('admin')->group(function() {
        Route::get('/dosens', [DosenController::class, 'index'])->name('dosens');
        Route::post('/dosens/import', [DosenController::class, 'import'])->name('dosens.import');
        Route::get('/dosens/{id}', [DosenController::class, 'edit'])->name('dosens.edit');
        Route::put('/dosens/{id}', [DosenController::class, 'update'])->name('dosens.update');
        Route::delete('/dosens/{id}', [DosenController::class, 'destroy'])->name('dosens.delete');

        Route::get('/mahasiswas', [MahasiswaController::class, 'index'])->name('mhs');
        Route::post('/mahasiswas/import', [MahasiswaController::class, 'import'])->name('mhs.import');
        Route::get('/mahasiswas/{id}', [MahasiswaController::class, 'edit'])->name('mhs.edit');
        Route::put('/mahasiswas/{id}', [MahasiswaController::class, 'update'])->name('mhs.update');
        Route::delete('/mahasiswas/{id}', [MahasiswaController::class, 'destroy'])->name('mhs.delete');

        Route::get('/matkuls', [MatkulController::class, 'index'])->name('matkuls');
        Route::get('/matkuls/create', [MatkulController::class, 'create'])->name('matkuls.create');
        Route::post('/matkuls/store', [MatkulController::class, 'store'])->name('matkuls.store');
        Route::post('/matkuls/import', [MatkulController::class, 'import'])->name('matkuls.import');
        Route::get('/matkuls/{id}', [MatkulController::class, 'edit'])->name('matkuls.edit');
        Route::put('/matkuls/{id}', [MatkulController::class, 'update'])->name('matkuls.update');
        Route::delete('/matkuls/{id}', [MatkulController::class, 'destroy'])->name('matkuls.destroy');

        Route::get('/nilais/{id}', [NilaiMhsController::class, 'show'])->name('admin.nilai.mhs');
        Route::post('/nilais/store', [NilaiMhsController::class, 'store'])->name('admin.nilai.mhs.store');
        Route::delete('/nilais/{id}', [NilaiMhsController::class, 'destroy'])->name('admin.nilai.mhs.destroy');

        Route::get('/indikators', [IndikatorController::class, 'index'])->name('indikators');
        Route::get('/indikators/create', [IndikatorController::class, 'create'])->name('indikators.create');
        Route::post('/indikators/store', [IndikatorController::class, 'store'])->name('indikators.store');
        Route::delete('/indikators/{id}', [IndikatorController::class, 'destroy'])->name('indikators.destroy');

        Route::get('/asesments', [AsesmentController::class, 'index'])->name('admin.asesments');
        Route::get('/asesments/create', [AsesmentController::class, 'create'])->name('admin.asesments.create');
        Route::post('/asesments/store', [AsesmentController::class, 'store'])->name('admin.asesments.store');
        Route::get('/asesments/edit/{id}', [AsesmentController::class, 'edit'])->name('admin.asesments.edit');
        Route::put('/asesments/update/{id}', [AsesmentController::class, 'update'])->name('admin.asesments.update');
        Route::delete('/asesments/delete/{id}', [AsesmentController::class, 'destroy'])->name('admin.asesments.delete');

        Route::get('/semesters', [SemesterController::class, 'index'])->name('admin.semesters');
        Route::post('/semesters/add', [SemesterController::class, 'store'])->name('admin.semesters.store');
        Route::get('/semesters/{id}', [SemesterController::class, 'show'])->name('admin.semesters.show');
        Route::post('/semesters/saveMhs', [SemesterController::class, 'saveMhs'])->name('admin.semesters.saveMhs');
        Route::get('/semesters/edit/{id}', [SemesterController::class, 'edit'])->name('admin.semesters.edit');
        Route::put('/semesters/enroll/{id}', [SemesterController::class, 'enrollSemester'])->name('admin.semesters.enrollSemester');
        Route::delete('/semesters/destroy/{id}', [SemesterController::class, 'destroy'])->name('admin.semesters.destroy');
    });
});

Route::group(['middleware' => ['auth', 'role:Dosen']], function() {
    Route::prefix('dosens')->group(function() {
        Route::get('/mahasiswas', [NilaiController::class, 'index'])->name('dosen.mhs');
        Route::get('/mahasiswas/add/{id}', [NilaiController::class, 'edit'])->name('dosen.mhs.edit');
        Route::get('/mahasiswas/{username}', [NilaiController::class, 'show'])->name('dosen.mhs.show');
        Route::put('/mahasiswas/insertNilai/{id}', [NilaiController::class, 'insertNilai'])->name('dosen.mhs.insertNilai');
        Route::put('/mahasiswas/lockNilai/{id}', [NilaiController::class, 'lockNilai'])->name('dosen.mhs.lockNilai');

        Route::get('/reports', [ReportShowController::class, 'index'])->name('dosen.report');
        Route::get('/reports/show/{id}', [ReportShowController::class, 'show'])->name('dosen.report.show');

        Route::get('/seminars', [SeminarShowController::class, 'index'])->name('dosen.seminars');
        Route::get('/seminars/show/{id}', [SeminarShowController::class, 'show'])->name('dosen.seminars.show');
        Route::get('/seminars/show/files/{id}', [SeminarShowController::class, 'showFiles'])->name('dosen.seminars.showFiles');

        Route::get('/jurnals', [JurnalShowController::class, 'index'])->name('dosen.jurnals');
        Route::get('/jurnals/show/{id}', [JurnalShowController::class, 'show'])->name('dosen.jurnals.show');
        Route::get('/jurnals/reading/{id}', [JurnalShowController::class, 'readingJurnals'])->name('dosen.jurnals.readingJurnals');
        Route::put('/jurnals/approved/{id}', [JurnalShowController::class, 'approved'])->name('dosen.jurnals.approved');

        Route::get('/asesments', [AsesmentDosenController::class, 'index'])->name('dosen.asesments');
    });
});

Route::group(['middleware' => ['auth', 'role:Mahasiswa']], function() {
    Route::prefix('portal')->group(function() {
        Route::prefix('list')->group(function() {
            Route::get('/matkuls', [MatkulMhsController::class, 'index'])->name('mhs.matkuls');
            Route::get('/matkuls/not-graduated', [MatkulMhsController::class, 'show'])->name('mhs.matkuls.show');
        });
    
        Route::prefix('loogbook')->group(function() {
            Route::get('/list', [LoogBookController::class, 'index'])->name('mhs.loogbook');
            Route::get('/create', [LoogBookController::class, 'create'])->name('mhs.loogbook.create');
            Route::post('/store', [LoogBookController::class, 'store'])->name('mhs.loogbook.store');
            Route::get('/list/{no_medis}', [LoogBookController::class, 'edit'])->name('mhs.loogbook.edit');
            Route::post('/list/update', [LoogBookController::class, 'update'])->name('mhs.loogbook.update');
            Route::delete('/list/delete/{id}', [LoogBookController::class, 'destroy'])->name('mhs.loogbook.destroy');
            Route::get('/list/check/{no_medis}', [LoogBookController::class, 'getRekamMedis'])->name('mhs.loogbook.getRekamMedis');
        });
    
        Route::prefix('report')->group(function() {
            Route::get('/list', [ReportController::class, 'index'])->name('mhs.report.list');
            Route::get('/uploads', [ReportController::class, 'create'])->name('mhs.report.uploads');
            Route::post('/uploads', [ReportController::class, 'store'])->name('mhs.report.uploads.store');
            Route::get('/presentation', [ReportController::class, 'lapPresentase'])->name('mhs.report.uploads.presentase');
            Route::post('/uploads/presentase/store', [ReportController::class, 'insertLapPresentation'])->name('mhs.report.uploads.insertLapPresentation');
            Route::delete('/list/delete/{id}', [ReportController::class, 'destroy'])->name('mhs.resport.delete');
        });

        Route::prefix('seminars')->group(function() {
            Route::get('/list', [SeminarController::class, 'index'])->name('mhs.seminar.list');
            Route::get('/uploads', [SeminarController::class, 'create'])->name('mhs.seminar.uploads');
            Route::post('/uploads', [SeminarController::class, 'store'])->name('mhs.seminar.uploads.store');
            Route::get('/list/show/{id}', [SeminarController::class, 'show'])->name('mhs.seminar.show');
            Route::get('/list/edit/{id}', [SeminarController::class, 'edit'])->name('mhs.seminar.edit');
            Route::put('/list/edit/{id}', [SeminarController::class, 'update'])->name('mhs.seminar.update');
            Route::delete('/list/delete/{id}', [SeminarController::class, 'destroy'])->name('mhs.seminar.delete');
        });

        Route::prefix('jurnals')->group(function() {
            Route::get('/list', [JurnalController::class, 'index'])->name('mhs.jurnal.list');
            Route::get('/uploads', [JurnalController::class, 'create'])->name('mhs.jurnal.uploads');
            Route::post('/uploads', [JurnalController::class, 'store'])->name('mhs.jurnal.uploads.store');
            Route::get('/approved', [JurnalController::class, 'paidJurnal'])->name('mhs.jurnal.paid');
            Route::get('/reading/{id}', [JurnalController::class, 'edit'])->name('mhs.jurnal.edit');
            Route::put('/reading/uploads/{id}', [JurnalController::class, 'update'])->name('mhs.jurnal.update');
            Route::get('/check/{title}', [JurnalController::class, 'getJudul'])->name('mhs.check.title');
        });

        Route::prefix('asesments')->group(function() {
            Route::get('/list', [AsesmentShowController::class, 'index'])->name('mhs.asesment.list');
            Route::get('/list/show/{slug}', [AsesmentShowController::class, 'show'])->name('mhs.asesments.show');
            Route::post('/store/asesments', [AsesmentShowController::class, 'storeAsesment'])->name('mhs.save.asesment');
        });
    });
});