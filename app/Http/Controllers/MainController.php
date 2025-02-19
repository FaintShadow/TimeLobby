<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainController extends Controller
{
    protected $roleDashboards = [
        'admin' => 'admin.institutes.index',
        'institute-admin' => 'institute.dashboard',
        'institute-manager' => 'institute.dashboard',
        'teacher' => 'institute.dashboard',
        'student' => 'institute.dashboard'
    ];

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->intended('/login');
        }

        $user = Auth::user();

        if (!$user->institute_id && $user->role !== 'admin') {
            return redirect()->route('noInstitute');
        }

        $route = $this->roleDashboards[$user->role] ?? 'logout';
        return redirect()->route($route);
    }
}
