<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstituteRequest;
use App\Http\Requests\UpdateInstituteRequest;
use App\Models\Institute;
use Inertia\Inertia;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Admin/Institutes/List', [
            'institutes' => Institute::select(['id', 'name'])->paginate(10)->each(function ($institute) {
                $institute['students'] = $institute->students()->count();
                $institute['academics'] = $institute->academicStaff()->count() + $institute->teachers()->count();
                return $institute;
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Institutes/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstituteRequest $request)
    {
        if ($request->validated()){
            Institute::create($request->validated());
            return redirect()->route('admin.institutes.index')->with('success', 'Institute created successfully.');
        }
        return back()->withErrors($request)->withInput();
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
        return Inertia::render('Admin/Institutes/Edit', []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstituteRequest $request, Institute $institute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        //
    }

    public function bulkDelete(Request $request){$request->validate([
           'ids' => ['required', 'array'],
        ]);

        Institute::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected institutes have been removed.');
    }
}
