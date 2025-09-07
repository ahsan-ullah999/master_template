<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index()
    {
        $seats = Seat::with('room')->paginate(10);
        return view('seats.list', compact('seats'));
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
}
