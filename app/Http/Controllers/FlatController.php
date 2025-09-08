<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FlatController extends Controller implements HasMiddleware
{
        public static function middleware(): array
    {
        return [
            new Middleware('permission:view flat', only: ['index']),
            new Middleware('permission:edit flat', only: ['edit']),
            new Middleware('permission:create flat', only: ['create']),
            new Middleware('permission:delete flat', only: ['delete']),
        ];
    }


    public function index()
    {
        $flats = Flat::with('floor')->paginate(10);
        return view('flats.list', compact('flats'));
    }

    public function create()
    {
        $floors = Floor::all();
        return view('flats.create', compact('floors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'name'     => 'required|string|max:255',
            'status'   => 'required|in:active,inactive',
        ]);

        Flat::create($request->all());

        return redirect()->route('flats.index')->with('success', 'Flat created successfully.');
    }

    public function edit(Flat $flat)
    {
        $floors = Floor::all();
        return view('flats.edit', compact('flat','floors'));
    }

    public function update(Request $request, Flat $flat)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'name' => 'required|string|max:255'
        ]);

        $flat->update($request->all());

        return redirect()->route('flats.index')->with('success','flats updated successfully.');
    }

    public function destroy($id)
    {
        $flat = Flat::findOrFail($id);
        $flat->delete();

        return redirect()->route('flats.index')->with('success', 'Flat deleted successfully.');
    }
}
