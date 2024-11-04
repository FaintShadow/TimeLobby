<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->institute_id) {
                $dashboard = new DashboardController();
                return $dashboard->index();
            } elseif (Auth::user()->role == 'admin'){
                return redirect()->route('admin.institutes.index');
            } else {
                return Inertia::render('noInstitute');
            }
        }
        return redirect()->intended('/login');
    }
}
