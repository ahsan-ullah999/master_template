<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SeatController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view seat', only: ['index']),
            new Middleware('permission:edit seat', only: ['edit']),
            new Middleware('permission:create seat', only: ['create']),
            new Middleware('permission:delete seat', only: ['delete']),
        ];
    }

    public function index(Request $request)
    {
        $query = Seat::with(['room.flat.floor.building']); // eager load relations
                                                             

        if ($request->search) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('seat_number', 'like', "%$search%")
                ->orWhereHas('room', fn($r) => $r->where('name', 'like', "%$search%"))
                ->orWhereHas('room.flat', fn($f) => $f->where('name', 'like', "%$search%"))
                ->orWhereHas('room.flat.floor.building', fn($b) => $b->where('name', 'like', "%$search%"));
            });
        }

        // 🎛 Filters
        if ($request->building_id) {
            $query->whereHas('room.flat.floor.building', fn($q) => $q->where('id', $request->building_id));
        }
        if ($request->flat_id) {
            $query->whereHas('room.flat', fn($q) => $q->where('id', $request->flat_id));
        }
        if ($request->room_id) {
            $query->where('room_id', $request->room_id);
        }

        $seats = $query->orderBy('id', 'DESC')->paginate(10);

        if ($request->ajax()) {
            return view('seats.partials.table', compact('seats'))->render();
        }

        // For filters dropdown
        $buildings = \App\Models\Building::all();
        $flats = \App\Models\Flat::all();
        $rooms = \App\Models\Room::all();

        return view('seats.list', compact('seats','buildings','flats','rooms'));
    }


    public function create()
    {
        $rooms = Room::orderBy('name', 'ASC')->get();
        return view('seats.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',   
            'seat_number' => 'required|string|max:255',
            'status'      => 'required|in:active,inactive', 
        ]);

        Seat::create($request->all());

        return redirect()->route('seats.index')->with('success','Seat created successfully');
    }

    public function edit($id)
    {
        $seat = Seat::findOrFail($id);
        $rooms = Room::orderBy('name','ASC')->get();
        return view('seats.edit', compact('seat','rooms'));
    }

    public function update(Request $request, $id)
    {
        $seat = Seat::findOrFail($id);

        $request->validate([
            'room_id'     => 'required|exists:rooms,id',   
            'seat_number' => 'required|string|max:50',
            'status'      => 'required|in:active,inactive', 
        ]);

        $seat->update($request->all());

        return redirect()->route('seats.index')->with('success','Seat updated successfully');
    }

    public function destroy($id)
    {
        $seat = Seat::findOrFail($id);
        $seat->delete();

        return redirect()->route('seats.index')->with('success','Seat deleted successfully');
    }

    // SeatController.php
    public function getFlats($buildingId)
    {
        $flats = \App\Models\Flat::whereHas('floor', function($q) use ($buildingId) {
            $q->where('building_id', $buildingId);
        })->get();

        return response()->json($flats);
    }

    public function getRooms($flatId)
    {
        $rooms = \App\Models\Room::where('flat_id', $flatId)->get();
        return response()->json($rooms);
    }
}
