<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\ProductOrder;
use App\Models\Room;
use App\Models\Seat;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
//use Spatie\Permission\Models\Role;


class MemberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // new Middleware('permission:view member', only: ['index']),
            new Middleware('permission:edit member', only: ['edit']),
            new Middleware('permission:create member', only: ['create']),
            new Middleware('permission:delete member', only: ['delete']),
            new Middleware('permission:suspend member', only: ['suspend']),
            new Middleware('permission:reactivate member', only: ['reactivate']),
        ];
    }



    /** LIST (active by default) */
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        foreach (['company_id','branch_id','building_id','floor_id','flat_id','room_id'] as $filter) {
            if ($request->$filter) {
                $query->where($filter, $request->$filter);
            }
        }

        $members = $query->orderBy('name')->paginate(10);

        if ($request->ajax()) {
            return view('members.partials.table', compact('members'))->render();
        }

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
 //       $roles = Role::orderBy('name','ASC')->get();

        return view('members.create', compact('companies','branches','buildings','floors','flats','rooms','seats'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'company_id'  => ['nullable','exists:companies,id'],
        'branch_id'   => ['nullable','exists:branches,id'],
        'building_id' => ['nullable','exists:buildings,id'],
        'floor_id'    => ['nullable','exists:floors,id'],
        'flat_id'     => ['nullable','exists:flats,id'],
        'room_id'     => ['nullable','exists:rooms,id'],
        'seat_id'     => ['required','array'],
        'seat_id.*'   => ['exists:seats,id'],
        'rental_id'   => ['required','string','max:100','unique:members,rental_id'],
        'admission_date' => ['required','date'],
        'effective_date' => ['required','date'],
        'photo'          => ['required','image','mimes:jpg,jpeg,png','max:2048'],
        'name'           => ['required','string','max:255'],
        'phone'          => ['required','string','max:30','unique:members'],
        'email'          => ['required','email','unique:members','max:255'],
        'date_of_birth'  => ['required','date'],
        'national_id'    => ['required','string','max:100'],
        'father_name'    => ['required','string','max:255'],
        'father_contact' => ['required','string','max:30'],
        'mother_name'    => ['nullable','string','max:255'],
        'blood_group'    => ['nullable','string','max:10'],
        'permanent_address' => ['nullable','string'],
        'local_guardian_name'      => ['nullable','string','max:255'],
        'local_guardian_relation'  => ['nullable','string','max:100'],
        'local_guardian_contact'   => ['nullable','string','max:30'],
        'status'         => ['nullable','in:active,suspended'],
    ]);

    // 🔹 Save photo
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('members', 'public');
    }

    // 1️⃣ Create Member first
    $member = Member::create(collect($data)->except('seat_id')->toArray());

    // 2️⃣ Create User linked to this Member
    $user = User::create([
        'name'       => $member->name,
        'email'      => $member->email,
        'password'   => Hash::make($data['password'] ?? '12345678'),
        'profile_image' => $member->photo,
        'type'       => 'member',
        'member_id'  => $member->id,
    ]);

    // 3️⃣ Link the user_id back to the member (optional)
    $member->update(['user_id' => $user->id]);

    // 4️⃣ Sync seats
    $member->seats()->sync($data['seat_id']);

    return redirect()->route('members.index')->with('success', 'Member created successfully');
}


    /** SHOW */
    public function show($id)
    {
        $member = \App\Models\Member::with([
            'company', 'branch', 'building', 'floor', 'flat', 'room', 'seats', 'user'
        ])->findOrFail($id);
        $orders = \App\Models\ProductOrder::with('routine')
            ->where('member_id', $member->id)
            ->where('status', '!=', 'cancelled')
            ->get();
          $startDate = Carbon::now()->subDays(30)->startOfDay();

        $orderCount = \App\Models\ProductOrder::where('member_id', $member->id)
        ->whereDate('order_date', '>=', $startDate)
        ->count();
        $balance = $orders->sum('grand_total');
        $totalDue = max(0, $balance - 0);

        return view('members.show', compact('member', 'orderCount', 'balance', 'totalDue'));
    }



        /** account */
    public function accountInfo($id)
    {
        // Load the member with related data
        $member = Member::with([
            'company', 'branch', 'building', 'floor', 'flat', 'room', 'seats', 'user'
        ])->findOrFail($id);

        // Load all non-cancelled orders with routine relationship
        $orders = ProductOrder::with(['routine', 'items.product', 'slot'])
            ->where('member_id', $member->id)
            ->where('status', '!=', 'cancelled')
            ->orderByDesc('order_date')
            ->get();

        // Set the start date (last 30 days)
        $startDate = Carbon::now()->subDays(30)->startOfDay();

        // Count the number of orders in the last 30 days
        $orderCount = ProductOrder::where('member_id', $member->id)
            ->where('status', '!=', 'cancelled')
            ->whereDate('order_date', '>=', $startDate)
            ->count();

        // Calculate total balance
        $balance = $orders->sum('grand_total');

        // If you later track payments, replace 0 with totalPaidAmount
        $totalDue = max(0, $balance - 0);

        return view('members.account', compact('member', 'orders', 'orderCount', 'balance', 'totalDue'));
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
        
 //       $roles = Role::orderBy('name','ASC')->get();

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

        // Multiple seat selection
        'seat_id'     => ['required','array'],
        'seat_id.*'   => ['exists:seats,id'],

        'rental_id'   => ['nullable','string','max:100','unique:members,rental_id,'.$member->id.',id'],

        'admission_date' => ['nullable','date'],
        'effective_date' => ['nullable','date'],

        'photo'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        'name'           => ['nullable','string','max:255'],
        'phone'          => ['nullable','string','max:30','unique:members,phone,'.$member->id],
        'email'          => ['nullable','max:255','unique:members,email,'.$member->id],

        // ✅ Make password optional, but must be at least 8 chars if given
        'password'       => ['nullable','string','min:8'],

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

    // ✅ Handle photo upload
    if ($request->hasFile('photo')) {
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        $data['photo'] = $request->file('photo')->store('members','public');
    }

    // ✅ Only hash password if user entered a new one
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']); // keep old password
    }

    // ✅ Update member except seat_id
    $member->update(collect($data)->except('seat_id')->toArray());

    // ✅ Sync seats (many-to-many)
    $member->seats()->sync($data['seat_id']);

    return redirect()->route('members.index')->with('success', 'Member updated successfully');
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
