<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /** LIST (active by default) */
    public function index(Request $request)
    {
        $query = Member::with(['company','branch','building','floor','flat','room','seat','user']);

        if ($request->filled('status') && in_array($request->status, ['active','suspended'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('rental_id', 'like', "%$s%");
            });
        }

        $members = $query->orderBy('created_at','DESC')->paginate(10);

        // return view later
        return view('members.list', compact('members'));
    }

    /** SUSPENDED LIST convenience (optional) */
    // public function suspended(Request $request)
    // {
    //     $members = Member::with(['company','branch'])->suspended()->orderBy('created_at','DESC')->paginate(10);
    //     return view('members.suspended', compact('members'));
    // }

    /** CREATE form */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        
        // Leave other dropdowns empty
        $branches = collect();
        $buildings = collect();
        $floors = collect();
        $flats = collect();
        $rooms = collect();
        $seats = collect();

        return view('members.create', compact('companies','branches','buildings','floors','flats','rooms','seats'));
    }

    /** STORE (all fields optional; validate only “exists” when provided) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'     => ['nullable','exists:users,id'],
            'company_id'  => ['nullable','exists:companies,id'],
            'branch_id'   => ['nullable','exists:branches,id'],
            'building_id' => ['nullable','exists:buildings,id'],
            'floor_id'    => ['nullable','exists:floors,id'],
            'flat_id'     => ['nullable','exists:flats,id'],
            'room_id'     => ['nullable','exists:rooms,id'],
            'seat_id'     => ['nullable','exists:seats,id'],

            'rental_id'   => ['nullable','string','max:100','unique:members,rental_id'],

            'admission_date' => ['nullable','date'],
            'effective_date' => ['nullable','date'],

            'photo'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'name'           => ['required','string','max:255'],
            'phone'          => ['nullable','string','max:30'],
            'email'          => ['nullable','email','max:255'],
            'date_of_birth'  => ['nullable','date'],
            'national_id'    => ['nullable','string','max:100'],

            'father_name'    => ['nullable','string','max:255'],
            'father_contact' => ['nullable','string','max:30'],
            'mother_name'    => ['nullable','string','max:255'],

            'blood_group'    => ['nullable','string','max:10'],
            'permanent_address' => ['nullable','string'],

            'local_guardian_name'      => ['nullable','string','max:255'],
            'local_guardian_relation'  => ['nullable','string','max:100'],
            'local_guardian_contact'   => ['nullable','string','max:30'],

            'status'         => ['nullable','in:active,suspended'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members','public');
        }

        Member::create($data);

        return redirect()->route('members.index')->with('success','Member created successfully');
    }

    /** SHOW */
     public function show($id)
     {
         $member = Member::with(['company','branch','building','floor','flat','room','seat','user'])->findOrFail($id);
         return view('members.show', compact('member'));
     }

    /** EDIT */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $companies = Company::orderBy('name')->get();

        // Load dependent dropdowns only if previous level is selected
        $branches  = $member->company_id 
            ? Branch::where('company_id', $member->company_id)->orderBy('name')->get()
            : collect();

        $buildings = $member->branch_id
            ? Building::where('branch_id', $member->branch_id)->orderBy('name')->get()
            : collect();

        $floors = $member->building_id
            ? Floor::where('building_id', $member->building_id)->orderBy('name')->get()
            : collect();

        $flats = $member->floor_id
            ? Flat::where('floor_id', $member->floor_id)->orderBy('name')->get()
            : collect();

        $rooms = $member->flat_id
            ? Room::where('flat_id', $member->flat_id)->orderBy('name')->get()
            : collect();

        $seats = $member->room_id
            ? Seat::where('room_id', $member->room_id)->orderBy('seat_number')->get()
            : collect();

        return view('members.edit', compact(
            'member','companies','branches','buildings','floors','flats','rooms','seats'
        ));
    }

    /** UPDATE */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $data = $request->validate([
            'user_id'     => ['nullable','exists:users,id'],
            'company_id'  => ['nullable','exists:companies,id'],
            'branch_id'   => ['nullable','exists:branches,id'],
            'building_id' => ['nullable','exists:buildings,id'],
            'floor_id'    => ['nullable','exists:floors,id'],
            'flat_id'     => ['nullable','exists:flats,id'],
            'room_id'     => ['nullable','exists:rooms,id'],
            'seat_id'     => ['nullable','exists:seats,id'],

            'rental_id'   => ['nullable','string','max:100','unique:members,rental_id,'.$member->id.',id'],

            'admission_date' => ['nullable','date'],
            'effective_date' => ['nullable','date'],

            'photo'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'name'           => ['nullable','string','max:255'],
            'phone'          => ['nullable','string','max:30'],
            'email'          => ['nullable','email','max:255'],
            'date_of_birth'  => ['nullable','date'],
            'national_id'    => ['nullable','string','max:100'],

            'father_name'    => ['nullable','string','max:255'],
            'father_contact' => ['nullable','string','max:30'],
            'mother_name'    => ['nullable','string','max:255'],

            'blood_group'    => ['nullable','string','max:10'],
            'permanent_address' => ['nullable','string'],

            'local_guardian_name'      => ['nullable','string','max:255'],
            'local_guardian_relation'  => ['nullable','string','max:100'],
            'local_guardian_contact'   => ['nullable','string','max:30'],

            'status'         => ['nullable','in:active,suspended'],
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $data['photo'] = $request->file('photo')->store('members','public');
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success','Member updated successfully');
    }

    /** DESTROY */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        $member->delete();

        return redirect()->route('members.index')->with('success','Member deleted successfully');
    }

    /** SUSPEND / REACTIVATE */
    public function suspend($id)
    {
        $member = Member::findOrFail($id);
        $member->update(['status' => 'suspended']);
        return redirect()->back()->with('success','Member suspended');
    }

    public function reactivate($id)
    {
        $member = Member::findOrFail($id);
        $member->update(['status' => 'active']);
        return redirect()->back()->with('success','Member reactivated');
    }

    /** --------- Dependent dropdown AJAX endpoints (JSON) ---------- */

    public function branchesByCompany($companyId)
    {
        return Branch::where('company_id', $companyId)->orderBy('name')->get(['id','name']);
    }

    public function buildingsByBranch($branchId)
    {
        return Building::where('branch_id', $branchId)->orderBy('name')->get(['id','name']);
    }

    public function floorsByBuilding($buildingId)
    {
        return Floor::where('building_id', $buildingId)->orderBy('name')->get(['id','name']);
    }

    public function flatsByFloor($floorId)
    {
        return Flat::where('floor_id', $floorId)->orderBy('name')->get(['id','name']);
    }

    public function roomsByFlat($flatId)
    {
        return Room::where('flat_id', $flatId)->orderBy('name')->get(['id','name']);
    }

    public function seatsByRoom($roomId)
    {
        return Seat::where('room_id', $roomId)
            ->orderBy('seat_number')
            ->get(['id','seat_number']);
    }
}
