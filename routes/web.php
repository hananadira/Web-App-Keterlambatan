<?php

use App\Http\Controllers\LateController;
use App\Http\Controllers\PsLateController;
use App\Http\Controllers\PsStudentController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboardps', function () {
    return view('ps.dashboard');
})->name('dashboardps');

Route::get('/', function() {
    return view('login');
})->name('login');
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');

Route::get('/error-permission', function() {
    return view('errors.permission');
})->name('error.permission');

Route::middleware('IsGuest')->group(function() {
    Route::get('/login', function() {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});

Route::middleware(['IsLogin'])->group(function() {
    Route::get('/', function() {
        return view('login');
    })->name('home.page');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::middleware(['IsLogin', 'IsAdmin'])->group(function() {
    Route::prefix('/user')->name('user.')->group(function() {
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/student')->name('student.')->group(function() {
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/{id}', [StudentController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/rombel')->name('rombel.')->group(function() {
        Route::get('/create', [RombelController::class, 'create'])->name('create');
        Route::post('/store', [RombelController::class, 'store'])->name('store');
        Route::get('/', [RombelController::class, 'index'])->name('index');
        Route::get('/{id}', [RombelController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [RombelController::class, 'update'])->name('update');
        Route::delete('/{id}', [RombelController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/rayon')->name('rayon.')->group(function() {
        Route::get('/create', [RayonController::class, 'create'])->name('create');
        Route::post('/store', [RayonController::class, 'store'])->name('store');
        Route::get('/', [RayonController::class, 'index'])->name('index');
        Route::get('/{id}', [RayonController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [RayonController::class, 'update'])->name('update');
        Route::delete('/{id}', [RayonController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/late')->name('late.')->group(function() {
        Route::get('/create', [LateController::class, 'create'])->name('create');
        Route::post('/store', [LateController::class, 'store'])->name('store');
        Route::get('/', [LateController::class, 'index'])->name('index');
        Route::get('/rekapitulasi', [LateController::class, 'rekapitulasi'])->name('rekapitulasi');
        Route::get('/export-excel', [LateController::class, 'exportExcel'])->name('export-excel');
        // Route::get('/rekapitulasi/rekapitulasid', [LateController::class, 'rekapitulasid'])->name('rekapitulasi.rekapitulasid');
        Route::get('/{id}', [LateController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [LateController::class, 'update'])->name('update');
        Route::delete('/{id}', [LateController::class, 'destroy'])->name('delete');
        Route::get('/lates/{name_id}', [LateController::class, 'show'])->name('rekapitulasi.show');
        Route::get('/print/{id}', [LateController::class, 'showPrint'])->name('rekapitulasi.print');
        Route::get('/download/{id}', [LateController::class, 'downloadPDF'])->name('download');
        
    });
    
    
    
});

Route::middleware(['IsLogin', 'IsPs'])->group(function() {
    Route::prefix('/ps')->name('ps.')->group(function() {
        Route::prefix('/student')->name('student.')->group(function() {
            Route::get('/', [PsStudentController::class, 'index'])->name('index.ps');
        });
        
        Route::prefix('/late')->name('late.')->group(function() {
            Route::get('/', [PsLateController::class, 'index'])->name('index');
            Route::get('/rekapitulasi', [PsLateController::class, 'rekapitulasi'])->name('rekapitulasi');
            Route::get('/export-excel', [PsLateController::class, 'PSexportExcel'])->name('export-excel.ps');
            Route::get('/late/{name_id}', [PsLateController::class, 'PSshow'])->name('show.ps');
            Route::get('/PSprint/{id}', [PsLateController::class, 'PSshowPrint'])->name('print.ps');
            Route::get('/download/{id}', [PsLateController::class, 'PSdownloadPDF'])->name('download.ps');
        });
    });
});