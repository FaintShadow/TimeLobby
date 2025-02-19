<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Group;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::select(['id', 'name'])
            ->withCount([
                'teachers',
                'groups'
            ])
            ->paginate(10)
            ->through(fn($institute) => [
                'id' => $institute->id,
                'name' => $institute->name,
                'teachers' => $institute->teachers_count,
                'groups' => $institute->groups_count,
            ]);

        return Inertia::render('InstituteAdmin/Courses/List', [
            'courses' => $courses,
            'links' => [
                'courses.create' => URL::route('institute.admin.courses.create'),
                'courses.edit' => URL::route('institute.admin.courses.edit', ['course' => 'replace-me']),
                'courses.bulk-delete' => URL::route('institute.admin.courses.bulk-delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('InstituteAdmin/Courses/Create', [
            'links' => [
                'courses.store' => URL::route('institute.admin.courses.store'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());
        $course->groups()->attach(Group::find($request->group_id));
        $course->save();
        return redirect()->route('institute.admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('InstituteAdmin/Courses/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
