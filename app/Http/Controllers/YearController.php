<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreYearRequest;
use App\Http\Requests\UpdateYearRequest;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreYearRequest $request)
    {
        $input = $request->validated();
        $year = Year::create($input);
        $year->institutes()->attach(Auth::user()->institute_id);
        return redirect()->route('institute.admin.groups.index')->with('success', 'Year created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Year $year)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Year $year)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateYearRequest $request, Year $year)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Year $year)
    {
        if (Auth::user()->can('delete', $year)){
            $year->delete();
            return redirect()->back()->with('success', 'Year deleted successfully.');
        }
        return redirect()->back()->with('error', 'You are not authorized to delete this year.');
    }

    public function search(Request $request)
    {
        return Year::search($request->search)->get();
    }
}
