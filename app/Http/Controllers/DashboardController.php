<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected $roleViewMappings = [
        'institute-admin' => 'InstituteAdmin/Dashboard',
        'institute-manager' => 'InstituteManager/Dashboard',
        'teacher' => 'Teacher/Dashboard',
        'student' => 'Student/Dashboard'
    ];

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $view = $this->roleViewMappings[$role] ?? null;

        if (!$view) {
            abort(403, 'Unauthorized role');
        }

        $viewData = $this->getDashboardData($role);

        return Inertia::render($view, $viewData);
    }

    protected function getDashboardData($role)
    {
        $data = [];

        switch ($role) {
            case 'institute-admin':
                break;
            case 'institute-manager':
                break;
            case 'teacher':
                break;
            case 'student':
                break;
        }

        return $data;
    }
}
