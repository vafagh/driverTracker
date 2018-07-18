<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('location.locations',compact('locations'));
    }


    public function store(Request $request)
    {
        $location = new Location;
        $location->type = $request->type;
        $location->name = $request->name;
        $location->person = $request->person;
        $location->phone = $request->phone;
        $location->distance = $request->distance;
        $location->line1 = $request->line1;
        $location->line2 = $request->line2;
        $location->city = $request->city;
        $location->state = $request->state;
        $location->zip = $request->zip;
        $location->save();

        return redirect('locations')->with($location->name.' Added');
    }

    public function show(Location $location)
    {
        return view('location.show',compact('location'));
    }

    public function edit(Location $location)
    {
        //
    }

    public function update(Request $request)
    {
        $location = Location::find($request->id);
        $location->type = $request->type;
        $location->name = $request->name;
        $location->person = $request->person;
        $location->phone = $request->phone;
        $location->distance = $request->distance;
        $location->line1 = $request->line1;
        $location->line2 = $request->line2;
        $location->city = $request->city;
        $location->state = $request->state;
        $location->zip = $request->zip;
        $location->save();

        return redirect()->back()->with($location->name.' updated');
    }

    public function destroy(Location $location)
    {
        Location::destroy($location->id);
        return redirect()->back()->with($location->name.' updated');
    }
}
