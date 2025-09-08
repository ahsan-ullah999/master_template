<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FloorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view floor', only: ['index']),
            new Middleware('permission:edit floor', only: ['edit']),
            new Middleware('permission:create floor', only: ['create']),
            new Middleware('permission:delete floor', only: ['delete']),
        ];
    }


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
