<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with('building')->paginate(10);
        return view('floors.list', compact('floors'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('floors.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255'
        ]);

        Floor::create($request->all());

        return redirect()->route('floors.index')->with('success','Floor created successfully.');
    }

    public function edit(Floor $floor)
    {
        $buildings = Building::all();
        return view('floors.edit', compact('floor','buildings'));
    }

    public function update(Request $request, Floor $floor)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255'
        ]);

        $floor->update($request->all());

        return redirect()->route('floors.index')->with('success','Floors updated successfully.');
    }

    public function destroy($id)
    {
        $floors = Building::find($id);

        if (!$floors) {
            return redirect()->route('floors.index')
                ->with('error', 'Floors not found');
        }

        $floors->delete();

        return redirect()->route('floors.index')
            ->with('success', 'Floors deleted successfully');
    }
}
