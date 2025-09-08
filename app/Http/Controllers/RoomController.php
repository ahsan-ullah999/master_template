<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoomController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view room', only: ['index']),
            new Middleware('permission:edit room', only: ['edit']),
            new Middleware('permission:create room', only: ['create']),
            new Middleware('permission:delete room', only: ['delete']),
        ];
    }

    public function index()
    {
        $rooms = Room::with('flat')->paginate(10);
        return view('rooms.list', compact('rooms'));
    }

    public function create()
    {
        $flats = Flat::orderBy('name','ASC')->get();
        return view('rooms.create', compact('flats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'name'    => 'required|string|max:255',
            'status'  => 'required|in:active,inactive',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success','Room created successfully');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $flats = Flat::orderBy('name','ASC')->get();
        return view('rooms.edit', compact('room','flats'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'name'    => 'required|string|max:255',
            'status'  => 'required|in:active,inactive',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success','Room updated successfully');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success','Room deleted successfully');
    }
}
