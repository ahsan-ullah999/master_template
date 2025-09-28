<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    $query = Slot::query();

    // Search filter
    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Sort filter
    if ($request->sort) {
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'ASC');
                break;
            case 'name_desc':
                $query->orderBy('name', 'DESC');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'ASC');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'DESC');
                break;
        }
    } else {
        // Default sort (by sort_order, then created_at desc)
        $query->orderBy('sort_order', 'ASC')
              ->orderBy('created_at', 'DESC');
    }

    $slots = $query->paginate(10);

    // If it's an AJAX request, return only the partial view
    if ($request->ajax()) {
        return view('slots.partials.table', compact('slots'))->render();
    }

    return view('slots.list', compact('slots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('slots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'name'=>'required',
            'start_time'=>'nullable',
            'end_time'=>'nullable',
            'order_cutoff_time'=>'nullable',
            'sort_order'=>'nullable|int',
            'status'=>'nullable']);
        Slot::create($data);
        return redirect()->route('slots.index')->with('success','Slot created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slot $slot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slot $slot)
    {
        return view('slots.edit', compact('slot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, Slot $slot)
    {
        $data = $r->validate([
            'name'=>'required',
            'start_time'=>'nullable',
            'end_time'=>'nullable',
            'order_cutoff_time'=>'nullable',
            'sort_order'=>'nullable|int',
            'status'=>'nullable']);
        $slot->update($data);
        return redirect()->route('slots.index')->with('success','Slot updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slot $slot)
    {
        $slot->delete(); 
        return redirect()->route('slots.index')->with('success','Slot deleted'); 
    }
}
