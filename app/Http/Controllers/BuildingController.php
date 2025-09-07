<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::with('branch')->paginate(10);
        return view('buildings.list', compact('buildings'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('buildings.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255'
        ]);

        Building::create($request->all());

        return redirect()->route('buildings.index')->with('success','Building created successfully.');
    }


    public function edit(Building $building)
    {
        $branches = Branch::all();
        return view('buildings.edit', compact('building','branches'));
    }

    public function update(Request $request, Building $building)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255'
        ]);

        $building->update($request->all());

        return redirect()->route('buildings.index')->with('success','Building updated successfully.');
    }

    public function destroy($id)
    {
        $buildings = Building::find($id);

        if (!$buildings) {
            return redirect()->route('buildings.index')
                ->with('error', 'Buildings not found');
        }

        $buildings->delete();

        return redirect()->route('buildings.index')
            ->with('success', 'Buildings deleted successfully');
    }
}
