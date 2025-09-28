<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Routine;
use App\Models\Slot;
use App\Models\RoutineItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
class RoutineController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // new Middleware('permission:view routine', only: ['index']),
            new Middleware('permission:edit routine', only: ['edit']),
            new Middleware('permission:create routine', only: ['create','store']),
            new Middleware('permission:delete routine', only: ['delete']),
        ];
    }



    public function index(Request $request)
    {
        $query = Routine::with(['slot','items.product','items.alternative','building','company','branch']);

        // search: we wrap into a single where to avoid or precedence issues
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('slot', fn($q2) => $q2->where('name', 'like', "%$search%"))
                  ->orWhereHas('items.product', fn($q2) => $q2->where('name', 'like', "%$search%"))
                  ->orWhereHas('items.alternative', fn($q2) => $q2->where('name', 'like', "%$search%"))
                  ->orWhere('date', 'like', "%$search%");
            });
        }

        // sort
        if ($request->sort === 'oldest') {
            $query->orderBy('created_at','asc');
        } else {
            $query->orderBy('created_at','desc');
        }

        $routines = $query->paginate(10);

        if ($request->ajax()) {
            return view('routines.partials.table', compact('routines'))->render();
        }

        return view('routines.list', compact('routines'));
    }

    public function create()
    {
        // load necessary lookup data (adjust models if names differ)
        $slots = Slot::where('status','active')->get();
        $products = Product::where('status','active')->get();

        // optional location lists (if models exist)
        $companies = class_exists(\App\Models\Company::class) ? \App\Models\Company::all() : collect();
        $branches  = class_exists(\App\Models\Branch::class)  ? \App\Models\Branch::all()  : collect();
        $buildings = class_exists(\App\Models\Building::class) ? \App\Models\Building::all() : collect();
        $floors    = class_exists(\App\Models\Floor::class)    ? \App\Models\Floor::all() : collect();
        $flats     = class_exists(\App\Models\Flat::class)     ? \App\Models\Flat::all() : collect();
        $rooms     = class_exists(\App\Models\Room::class)     ? \App\Models\Room::all() : collect();

        return view('routines.create', compact(
            'slots','products','companies','branches','buildings','floors','flats','rooms'
        ));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'company_id'=>'nullable|integer',
            'branch_id'=>'nullable|integer',
            'building_id'=>'nullable|integer',
            'floor_id'=>'nullable|integer',
            'flat_id'=>'nullable|integer',
            'room_id'=>'nullable|integer',
            'slot_id'=>'required|exists:slots,id',
            // 'product_id' no longer required — items array used
            'day_of_week'=>'nullable|integer|min:0|max:6',
            'date'=>'nullable|date',
            'product_count'=>'nullable|integer|min:1',
            'notes'=>'nullable|string',
            'items'=>'required|array|min:1',
            'items.*.product_id'=>'required|exists:products,id',
            'items.*.alternative_product_id'=>'nullable|exists:products,id',
            'items.*.is_optional'=>'nullable|boolean',
            'items.*.position'=>'nullable|integer',
        ]);

        // create main routine (we don't set product_id because items are multiple)
        $routine = Routine::create([
            'company_id' => $data['company_id'] ?? null,
            'branch_id'  => $data['branch_id'] ?? null,
            'building_id'=> $data['building_id'] ?? null,
            'floor_id'   => $data['floor_id'] ?? null,
            'flat_id'    => $data['flat_id'] ?? null,
            'room_id'    => $data['room_id'] ?? null,
            'slot_id'    => $data['slot_id'],
            'day_of_week'=> $data['day_of_week'] ?? null,
            'date'       => $data['date'] ?? null,
            'product_count' => $data['product_count'] ?? count($data['items']),
            'notes'      => $data['notes'] ?? null,
        ]);

        // insert items
        foreach ($data['items'] as $i => $it) {
            RoutineItem::create([
                'routine_id' => $routine->id,
                'product_id' => $it['product_id'],
                'alternative_product_id' => $it['alternative_product_id'] ?? null,
                'is_optional' => isset($it['is_optional']) && $it['is_optional'] ? 1 : 0,
                'position' => $it['position'] ?? $i,
            ]);
        }

        return redirect()->route('routines.index')->with('success','Routine saved');
    }

    public function show(Routine $routine)
    {
        $routine->load(['slot','items.product','items.alternative','building','company','branch']);
        return view('routines.show', compact('routine'));
    }

    public function edit(Routine $routine)
    {
        $routine->load('items');

        $slots = Slot::where('status','active')->get();
        $products = Product::where('status','active')->get();

        $companies = class_exists(\App\Models\Company::class) ? \App\Models\Company::all() : collect();
        $branches  = class_exists(\App\Models\Branch::class)  ? \App\Models\Branch::all()  : collect();
        $buildings = class_exists(\App\Models\Building::class) ? \App\Models\Building::all() : collect();
        $floors    = class_exists(\App\Models\Floor::class)    ? \App\Models\Floor::all() : collect();
        $flats     = class_exists(\App\Models\Flat::class)     ? \App\Models\Flat::all() : collect();
        $rooms     = class_exists(\App\Models\Room::class)     ? \App\Models\Room::all() : collect();

        return view('routines.edit', compact(
            'routine','slots','products','companies','branches','buildings','floors','flats','rooms'
        ));
    }

    public function update(Request $r, Routine $routine)
    {
        $data = $r->validate([
            'company_id'=>'nullable|integer',
            'branch_id'=>'nullable|integer',
            'building_id'=>'nullable|integer',
            'floor_id'=>'nullable|integer',
            'flat_id'=>'nullable|integer',
            'room_id'=>'nullable|integer',
            'slot_id'=>'required|exists:slots,id',
            'day_of_week'=>'nullable|integer|min:0|max:6',
            'date'=>'nullable|date',
            'product_count'=>'nullable|integer|min:1',
            'notes'=>'nullable|string',
            'items'=>'required|array|min:1',
            'items.*.product_id'=>'required|exists:products,id',
            'items.*.alternative_product_id'=>'nullable|exists:products,id',
            'items.*.is_optional'=>'nullable|boolean',
            'items.*.position'=>'nullable|integer',
        ]);

        $routine->update([
            'company_id' => $data['company_id'] ?? null,
            'branch_id'  => $data['branch_id'] ?? null,
            'building_id'=> $data['building_id'] ?? null,
            'floor_id'   => $data['floor_id'] ?? null,
            'flat_id'    => $data['flat_id'] ?? null,
            'room_id'    => $data['room_id'] ?? null,
            'slot_id'    => $data['slot_id'],
            'day_of_week'=> $data['day_of_week'] ?? null,
            'date'       => $data['date'] ?? null,
            'product_count' => $data['product_count'] ?? count($data['items']),
            'notes'      => $data['notes'] ?? null,
        ]);

        // replace items: simplest approach - delete then re-insert
        $routine->items()->delete();
        foreach ($data['items'] as $i => $it) {
            RoutineItem::create([
                'routine_id' => $routine->id,
                'product_id' => $it['product_id'],
                'alternative_product_id' => $it['alternative_product_id'] ?? null,
                'is_optional' => isset($it['is_optional']) && $it['is_optional'] ? 1 : 0,
                'position' => $it['position'] ?? $i,
            ]);
        }

        return redirect()->route('routines.index')->with('success','Routine updated');
    }

    public function destroy(Routine $routine)
    {
        $routine->delete(); 
        return redirect()->route('routines.index')->with('success','Routine deleted');
    }
}
