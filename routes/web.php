<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\admin\InstituteController;
use App\Http\Controllers\BuildingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Academic User:
Route::middleware(['auth', 'hasInstitute', 'isAcademicUser'])->group(function () {

    Route::name('activity')->prefix('activity')->group(function () {
        Route::get('', [ActivityController::class, 'index'])->name('.index');
        Route::get('/add', [ActivityController::class, 'create'])->name('.create');
        Route::post('/view', [ActivityController::class, 'show'])->name('.show');
    });

    Route::name('buildings')->prefix('buildings')->group(function () {
        Route::get('/', [BuildingController::class, 'index'])->name('.index');
        Route::get('/create', [BuildingController::class, 'create'])->name('.create');
        Route::post('/view', [BuildingController::class, 'store'])->name('.view');
        Route::post('/store', [BuildingController::class, 'store'])->name('.store');
    });
});

// Admin:
Route::middleware(['auth', 'isAdmin'])->name('admin.')->prefix('/admin')->group(function () {

    Route::prefix('/institutes')->name('institutes.')->group(function () {
        Route::get('', [InstituteController::class, 'index'])->name('index');
        Route::get('/add', [InstituteController::class, 'create'])->name('create');
        Route::post('/add', [InstituteController::class, 'store'])->name('store');
        Route::get('/edit/{institute}', [InstituteController::class, 'edit'])->name('edit');

        Route::delete('/bulkdelete', [InstituteController::class, 'bulkDelete'])->name('bulk-delete');
    });

});
