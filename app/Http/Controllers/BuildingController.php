<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BuildingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view building', only: ['index']),
            new Middleware('permission:edit building', only: ['edit']),
            new Middleware('permission:create building', only: ['create']),
            new Middleware('permission:delete building', only: ['delete']),
        ];
    }

    public function index(Request $request)
    {
        $query = Building::with('branch');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhereHas('branch', function ($b) use ($search) {
                    $b->where('name', 'like', "%{$search}%");
                });
            });
        }

        $buildings = $query->paginate(10);

        if ($request->ajax()) {
            return view('buildings.partials.table', compact('buildings'))->render();
        }

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
