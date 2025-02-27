<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Models\Institute;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('InstituteAdmin/Groups/List', [
            'years' => Institute::find(Auth::user()->institute_id)->years()->with('groups.subgroups')->get(),
            'links' => [
                'groups.add' => URL::route('institute.admin.groups.create'),
                'groups.edit' => URL::route('institute.admin.groups.edit', ['group' => 'replace-me']),
                'groups.bulk-delete' => URL::route('institute.admin.groups.bulk-delete'),
                'years.store' => URL::route('institute.admin.years.store'),
                'years.delete' => URL::route('institute.admin.years.delete', ['year' => 'replace-me']),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('InstituteAdmin/Groups/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $input = $request->validated();

        if ($input['groupType'] === 'subgroup') {
            $mainGroup = Group::find($input['main_group_id']);

            // Check if the institute is associated with this group through the pivot table
            if (!Auth::user()->institute->subgroups()->where('group_id', $mainGroup->id)->exists()) {
                // Add both the group and its year to the institute if the year doesn't exist
                if (!Auth::user()->institute->years()->find($mainGroup->year_id)) {
                    Auth::user()->institute->years()->attach($mainGroup->year_id);
                }

                Auth::user()->institute->subgroups()->attach($mainGroup);
                $input['year_id'] = $mainGroup->year_id;
            }
        } else if (!Auth::user()->institute->years()->find($input['year_id'])) {
            Auth::user()->institute->years()->attach(Year::find($input['year_id']));
        }

        $group = Group::create($input);
        if ($input['groupType'] === 'subgroup') {
            $group->main_group_id = $input['main_group_id'];
            $group->save();
        }
        return redirect()->route('institute.admin.groups.index')->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return Inertia::render('InstituteAdmin/Groups/Edit', [
            'group' => $group->load('subgroups'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function search(Request $request)
    {
        return Group::search($request->search)
            ->where('main_group_id', $request->type == 'group' ? null : '%')
            ->get()->load('year');
    }

    /**
     * Remove a list of specified resources
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
        ]);

        Group::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected buildings have been removed.');
    }

}
