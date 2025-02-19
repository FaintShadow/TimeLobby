<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstituteRequest;
use App\Http\Requests\UpdateInstituteRequest;
use App\Models\Institute;
use Barryvdh\Debugbar\Facades\Debugbar;
use Inertia\Inertia;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutes = Institute::select(['id', 'name'])
            ->withCount([
                'students',
                'academicStaff',
                'teachers'
            ])
            ->paginate(10)
            ->through(fn($institute) => [
                'id' => $institute->id,
                'name' => $institute->name,
                'students' => $institute->students_count,
                'academics' => $institute->academic_staff_count + $institute->teachers_count,
            ]);

        return Inertia::render('Admin/Institutes/List', [
            'institutes' => $institutes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Institutes/Create', [
            'links' => [
                'admin.institutes.store' => route('admin.institutes.store'),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstituteRequest $request)
    {
        Institute::create($request->validated());
        return redirect()->route('admin.institutes.index')->with('success', 'Institute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institute $institute)
    {
        return Inertia::render('Admin/Institutes/Edit', [
            'institute' => $institute
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstituteRequest $request, Institute $institute)
    {
        $institute->update($request->validated());
        return redirect()->route('admin.institutes.index')->with('success', 'Institute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        //
    }

    /**
     * Remove a list of specified resources
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
        ]);

        Institute::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected institutes have been removed.');
    }

    /**
     * Admin specific search function:
     */
    public function Search(Request $request)
    {
        return Institute::search($request->search)->get();
    }
}
