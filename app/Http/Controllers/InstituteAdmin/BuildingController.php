<?php

namespace App\Http\Controllers\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('InstituteAdmin/Buildings/List', [
            'buildings' => Building::with('building')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('InstituteAdmin/Buildings/Create', [
            'buildingMinCap' => Building::$buildingMinCap,
            'classroomMinCap' => Building::$classroomMinCap,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.unique' => 'Given name already exists.',
            'building_id.required' => 'A building is required',
            'building_id.max_rooms' => 'The selected building has reached its maximum room capacity.',
        ];

        $validationRules = [
            'name' => [
                'required',
                'string',
                'max:32',
                'min:2',
                Rule::unique('buildings')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)
                        ->where('institute_id', Auth::user()->institute_id);
                }),
            ],
            'maxCapacity' => [
                'integer',
                'min:' . ($request->type == 'building' ? Building::$buildingMinCap : Building::$classroomMinCap),
            ],
        ];

        if ($request->type == 'classroom') {
            $validationRules['building_id'] = [
                'required',
                'integer',
                'min:1',
                'exists:buildings,id',
                function ($attribute, $value, $fail) {
                    $parentBuilding = Building::find($value);

                    if (!$parentBuilding) {
                        return $fail('The selected building does not exist.');
                    }

                    $currentRoomCount = $parentBuilding->classes()->count();

                    if ($currentRoomCount >= $parentBuilding->maxCapacity) {
                        return $fail('The selected building has reached its maximum room capacity.');
                    }
                }
            ];
        }

        $validatedData = Validator::make($request->all(), $validationRules, $messages)->validate();
        $validatedData['institute_id'] = Auth::user()->institute_id;
        Building::create($validatedData);

        return redirect()->route('institute.admin.buildings.index')->with('success', 'Building has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        return Inertia::render('InstituteAdmin/Buildings/Edit', [
            'building' => $building,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $building->update($request->validated());
        return redirect()->route('institute.admin.buildings.index')->with('success', 'Building has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
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

        Building::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected buildings have been removed.');
    }

    public function search(Request $request)
    {
        return Building::search($request->search)
            ->where('institute_id', Auth::user()->institute_id)
            ->where('building_id', $request->type == 'building' ? null : '%')
            ->get();
    }

    public function ui(){
        return Inertia::render('InstituteAdmin/Buildings/Visualizer', [
            'buildings' => Building::whereNull('building_id')->get(),
        ]);
    }
}
