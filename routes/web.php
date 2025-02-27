<?php

use App\Http\Controllers\admin\AcademicController;
use App\Http\Controllers\admin\InstituteController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InstituteAdmin\BuildingController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'hasNoInstitute', 'verified'])->name('noInstitute')->get('no-institute', function () {
   return Inertia::render('NoInstitute');
});

// Academic User:
Route::middleware(['auth', 'hasInstitute', 'isAcademicUser', 'verified'])->name('institute.')->prefix('/institute')->group(function () {

    //Dashboard:
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');

    // Academic Admin:
    Route::middleware('isInstituteAdmin')->name('admin.')->prefix('/admin')->group(function () {

        // Buildings:
        Route::name('buildings.')->prefix('/buildings')->group(function () {
            Route::get('', [BuildingController::class, 'index'])->name('index');

            Route::get('/add', [BuildingController::class, 'create'])->name('create');
            Route::post('/store', [BuildingController::class, 'store'])->name('store');

            Route::get('/edit/{building}', [BuildingController::class, 'edit'])->name('edit');
            Route::put('/update/{building}', [BuildingController::class, 'update'])->name('update');

            Route::get('/view/{building}', [BuildingController::class, 'show'])->name('show');

            Route::delete('/bulkdelete', [BuildingController::class, 'bulkDelete'])->name('bulk-delete');

            Route::get('/ui', [BuildingController::class, 'ui'])->name('ui');
        });

        // Groups:
        Route::name('groups.')->prefix('/groups')->group(function () {
            Route::get('', [GroupController::class, 'index'])->name('index');

            Route::get('/add', [GroupController::class, 'create'])->name('create');
            Route::post('/store', [GroupController::class, 'store'])->name('store');

            Route::get('/edit/{group}', [GroupController::class, 'edit'])->name('edit');
            Route::put('/update/{group}', [GroupController::class, 'update'])->name('update');

            Route::get('/view/{institute}', [GroupController::class, 'show'])->name('show');

            Route::delete('/bulkdelete', [GroupController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Year:
        Route::name('years.')->prefix('/years')->group(function () {
            Route::get('', [YearController::class, 'index'])->name('index');

            Route::get('/add', [YearController::class, 'create'])->name('create');
            Route::post('/store', [YearController::class, 'store'])->name('store');

            Route::get('/edit/{year}', [YearController::class, 'edit'])->name('edit');
            Route::put('/update/{institute}', [YearController::class, 'update'])->name('update');

            Route::get('/view/{institute}', [YearController::class, 'show'])->name('show');

            Route::delete('/delete/{year}', [YearController::class, 'destroy'])->name('delete');
            Route::delete('/bulkdelete', [YearController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Course:
        Route::name('courses.')->prefix('/courses')->group(function () {
            Route::get('', [CourseController::class, 'index'])->name('index');

            Route::get('/add', [CourseController::class, 'create'])->name('create');
            Route::post('/store', [CourseController::class, 'store'])->name('store');

            Route::get('/edit/{course}', [CourseController::class, 'edit'])->name('edit');
            Route::put('/update/{course}', [CourseController::class, 'update'])->name('update');

            Route::get('/view/{course}', [CourseController::class, 'show'])->name('show');

            Route::delete('/bulkdelete', [CourseController::class, 'bulkDelete'])->name('bulk-delete');
        });

    });
});

// Admin:
Route::middleware(['auth', 'isAdmin', 'verified'])->name('admin.')->prefix('/admin')->group(function () {

    Route::prefix('/institutes')->name('institutes.')->group(function () {
        Route::get('', [InstituteController::class, 'index'])->name('index');

        Route::get('/add', [InstituteController::class, 'create'])->name('create');
        Route::post('/store', [InstituteController::class, 'store'])->name('store');

        Route::get('/edit/{institute}', [InstituteController::class, 'edit'])->name('edit');
        Route::put('/update/{institute}', [InstituteController::class, 'update'])->name('update');

        Route::get('/view/{institute}', [InstituteController::class, 'show'])->name('show');

        Route::delete('/bulkdelete', [InstituteController::class, 'bulkDelete'])->name('bulk-delete');
    });

    Route::prefix('/academics')->name('academics.')->group(function () {
        Route::get('', [AcademicController::class, 'index'])->name('index');

        Route::get('/add', [AcademicController::class, 'create'])->name('create');
        Route::post('/add', [AcademicController::class, 'store'])->name('store');

        Route::get('/edit/{academic}', [AcademicController::class, 'edit'])->name('edit');
        Route::put('/update/{academic}', [AcademicController::class, 'update'])->name('update');

        Route::put('/assign/{academic}', [AcademicController::class, 'assign'])->name('assign');

        Route::get('/view/{academic}', [AcademicController::class, 'show'])->name('show');

        Route::delete('/bulkdelete', [AcademicController::class, 'bulkDelete'])->name('bulk-delete');
    });

});

