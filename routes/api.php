<?php

// Admin:
use App\Http\Controllers\admin\InstituteController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InstituteAdmin\BuildingController;
use App\Http\Controllers\YearController;

Route::middleware(['auth', 'isAdmin', 'web'])->group(function () {

    Route::prefix('/institutes')->name('institutes.')->group(function () {
        Route::post('/search', [InstituteController::class, 'search'])->name('search');
    });

});


// Institute Admin:
Route::middleware(['auth', 'isInstituteAdmin', 'web'])->group(function () {

    Route::prefix('/buildings')->name('buildings.')->group(function () {
        Route::post('/search', [BuildingController::class, 'search'])->name('search');
    });

    Route::prefix('/groups')->name('groups.')->group(function () {
        Route::post('/search', [GroupController::class, 'search'])->name('search');
    });

    Route::prefix('/years')->name('years.')->group(function () {
        Route::post('/search', [YearController::class, 'search'])->name('search');
    });

});
