<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\Room;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
        */
    public function index(Request $request)
    {
        $query = \App\Models\Notice::with(['company', 'branch', 'building', 'floor', 'flat', 'room']);

        // 🔍 Search filter (by title)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $notices = $query->latest()->paginate(10);

        // 🔹 For AJAX requests — return only the table
        if ($request->ajax()) {
            return view('notices.partials.table', compact('notices'))->render();
        }

        return view('notices.index', compact('notices'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $branches = collect();
        $buildings = collect();
        $floors = collect();
        $flats = collect();
        $rooms = collect();

        return view('notices.create', compact('companies','branches','buildings','floors','flats','rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id'  => 'nullable|exists:companies,id',
            'branch_id'   => 'nullable|exists:branches,id',
            'building_id' => 'nullable|exists:buildings,id',
            'floor_id'    => 'nullable|exists:floors,id',
            'flat_id'     => 'nullable|exists:flats,id',
            'room_id'     => 'nullable|exists:rooms,id',
            'title'       => 'required|string|max:255',
            'details'     => 'nullable|string',
            'priority'    => 'required|in:normal,high,urgent',
        ]);

        Notice::create($data);

        return redirect()->route('notices.index')
            ->with('success', 'Notice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        $notice->load(['company','branch','building','floor','flat','room']);
        return view('notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        $companies = Company::orderBy('name')->get();

        $branches = Branch::where('company_id', $notice->company_id)->orderBy('name')->get();
        $buildings = Building::where('branch_id', $notice->branch_id)->orderBy('name')->get();
        $floors = Floor::where('building_id', $notice->building_id)->orderBy('name')->get();
        $flats = Flat::where('floor_id', $notice->floor_id)->orderBy('name')->get();
        $rooms = Room::where('flat_id', $notice->flat_id)->orderBy('name')->get();

        return view('notices.edit', compact(
            'notice',
            'companies',
            'branches',
            'buildings',
            'floors',
            'flats',
            'rooms'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'company_id'  => 'nullable|exists:companies,id',
            'branch_id'   => 'nullable|exists:branches,id',
            'building_id' => 'nullable|exists:buildings,id',
            'floor_id'    => 'nullable|exists:floors,id',
            'flat_id'     => 'nullable|exists:flats,id',
            'room_id'     => 'nullable|exists:rooms,id',
            'title'       => 'required|string|max:255',
            'details'     => 'nullable|string',
            'priority'    => 'required|in:normal,high,urgent',
        ]);

        $notice->update($data);

        return redirect()->route('notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()->route('notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
}
