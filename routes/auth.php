<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\MainController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Password;
use App\Models\User;


Route::get('', [MainController::class, 'index'])->name('home');

// Guest:
Route::middleware('guest')->group(function () {
    Route::any('register', [AuthController::class, 'register'])->name('register');

    Route::name('login')->group(function () {
        Route::get('login', [LoginController::class, 'create']);
        Route::post('login', [LoginController::class, 'store']);
    });


    // Password Reset:
    Route::name('password.request')->get('/forgot-password', function () {
        return Inertia::render('Auth/ForgotPassword')
            ->with(['links' => [
                'password.email' => route('password.email')
                ]]);
    });

    Route::name('password.email')->post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    });

    Route::name('password.reset')->get('/reset-password', function (Request $request) {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $request->token,
            'email' => urldecode(base64_decode($request->email_token))
        ]);
    });

    Route::name('password.update')->post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    });

});

// Auth routes:
Route::middleware('auth')->group(function () {
    Route::name('logout')->get('logout', [AuthController::class, 'logout']);

    Route::middleware('notVerified')->name('verification.notice')->get('/email/verify', function () {
        return Inertia::render('Auth/VerifyEmail');
    });

    Route::middleware('signed')->name('verification.verify')->get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home');
    });

    // middleware('throttle:4,1')->
    Route::name('verification.send')->post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    });
});
