<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        //
    }

    public function register(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'firstname' => ['required', 'string', 'min:3'],
                    'lastname' => ['required', 'string', 'min:3'],
                    'email' => ['required', 'email'],
                    'password' => ['required', Password::defaults()],
                    'password_confirmation' => ['required', 'same:password'],
                ],
                [
                    'password_confirmation.same' => 'The password confirmation does not match.',
                ]
            );

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $input = $validator->validated();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);

                Auth::login($user);

                return redirect()->route('home');
            }
        }

        return Inertia::render('Auth/Register', [
            'errors' => session('errors') ? session('errors')->getBag('default')->toArray() : [],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}