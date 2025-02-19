<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: add name selection security:
        $academics = User::where('role', 'not like', 'admin')->with('institute')->paginate(10);
        return Inertia::render('Admin/Academics/List_new', [
            'academics' => $academics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $academic)
    {
        return Inertia::render('Admin/Academics/Edit', [
            'academic' => $academic->load('institute'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $academic)
    {
        $messages = [
            'institute_id.exists' => 'The selected institute is invalid',
            'institute_id.required_without_all' => 'The institute field is required.'
        ];

        $input = $request->validate([
            'institute_id' => ['nullable', 'exists:institutes,id'],
            'role' => ['nullable', 'in:institute-admin,institute-manager,teacher,student']
        ], $messages);

        $academic->update($input);

        return redirect()
            ->route('admin.academics.index')
            ->with('success', 'Academic updated successfully.');
    }

    public function assign(Request $request, User $academic)
    {
        $input = $request->validate([
            'id' => ['required', 'exists:users,id'],
            'institute_id' => ['required', 'exists:institutes,id'],
        ]);

        if ($input) {
            $academic->update($input);
            return back()->with('success', 'Academic updated successfully.');
        }

        return back()->with('error', 'Error updating academic, please try again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
        ]);

        User::whereNotNull('role')->whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected academics have been removed.');
    }
}
