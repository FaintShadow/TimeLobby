<?php

use App\Http\Middleware\hasInstitute;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\hasNoInstitute;
use App\Http\Middleware\isAcademicUser;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isInstituteAdmin;
use App\Http\Middleware\notVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::namespace('Auth')->middleware('web')->group(base_path('routes/auth.php'));
            Route::namespace('API')->prefix('/api')->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
        $middleware->alias([
            'hasInstitute' => hasInstitute::class,
            'hasNoInstitute' => hasNoInstitute::class,
            'isAcademicUser' => isAcademicUser::class,
            'isAdmin' => isAdmin::class,
            'isInstituteAdmin' => isInstituteAdmin::class,
            'notVerified' => notVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
